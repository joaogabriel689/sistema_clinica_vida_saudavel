<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Fatura;
use App\Models\Assinatura;
use App\Models\Plano;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Especialidade;
use App\Jobs\EnviarNotificacaoWhatsAppJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Tests\TestCase;

class SaaSAdvancedFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_asaas_updates_fatura_and_assinatura_to_paga(): void
    {
        $this->withoutMiddleware();

        $admin = User::factory()->create(['role' => 'admin']);
        $clinica = Clinica::create([
            'nome' => 'Clínica Webhook',
            'endereco' => 'Rua Webhook 123',
            'telefone' => '11999990000',
            'cnpj' => '11.222.333/0001-44',
            'slug' => 'clinica-webhook',
            'user_id' => $admin->id,
        ]);

        $plano = Plano::create([
            'nome' => 'Pro',
            'slug' => 'pro',
            'preco_mensal' => 199.90,
            'limite_medicos' => 5,
            'limite_consultas_mes' => 500,
        ]);

        $assinatura = Assinatura::create([
            'clinica_id' => $clinica->id,
            'plano_id' => $plano->id,
            'status' => 'trial',
            'trial_ends_at' => Carbon::now()->addDays(7),
            'proxima_cobranca' => Carbon::now()->addDays(7),
            'gateway' => 'asaas',
        ]);

        $fatura = Fatura::create([
            'assinatura_id' => $assinatura->id,
            'valor' => 199.90,
            'status' => 'pendente',
            'data_vencimento' => Carbon::now()->addDays(3),
        ]);

        $response = $this->postJson(route('webhooks.asaas'), [
            'event' => 'PAYMENT_RECEIVED',
            'payment' => [
                'id' => $fatura->id,
                'value' => 199.90,
                'status' => 'RECEIVED',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $fatura->refresh();
        $this->assertEquals('paga', $fatura->status);
        $this->assertNotNull($fatura->data_pagamento);

        $assinatura->refresh();
        $this->assertEquals('ativa', $assinatura->status);
    }

    public function test_webhook_asaas_rejects_unauthorized_token_header(): void
    {
        config(['services.asaas.webhook_token' => 'token_secreto_valido']);

        $response = $this->postJson(route('webhooks.asaas'), [
            'event' => 'PAYMENT_RECEIVED',
            'payment' => ['id' => 999]
        ], [
            'asaas-access-token' => 'token_invalido_hacker'
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Token de webhook inválido.']);
    }

    public function test_enviar_lembretes_consultas_command_dispatches_whatsapp_job(): void
    {
        Queue::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $clinica = Clinica::create([
            'nome' => 'Clínica Lembretes',
            'endereco' => 'Rua Lembretes 123',
            'telefone' => '11999990000',
            'cnpj' => '22.333.444/0001-55',
            'slug' => 'clinica-lembretes',
            'user_id' => $admin->id,
        ]);

        $medicoUser = User::factory()->create([
            'role' => 'medico',
            'clinica_id' => $clinica->id,
        ]);

        $esp = Especialidade::create([
            'nome' => 'Cardiologia',
            'descricao' => 'Cardiologia Geral',
        ]);

        $medico = Medico::create([
            'clinica_id' => $clinica->id,
            'user_id' => $medicoUser->id,
            'especialidade_id' => $esp->id,
            'nome' => 'Dr. Pedro Lembrete',
            'crm' => 'CRM/SP 998877',
            'especialidade' => 'Cardiologia',
            'telefone' => '11988887777',
            'valor_consulta' => 200.00,
            'horario_inicio' => '08:00',
            'horario_fim' => '18:00',
        ]);

        $paciente = Paciente::create([
            'clinica_id' => $clinica->id,
            'nome' => 'Maria Souza',
            'cpf' => '12345678901',
            'telefone' => '11977776666',
            'endereco' => 'Rua das Flores 10',
            'data_nascimento' => '1990-05-15',
        ]);

        $consulta = Consulta::create([
            'clinica_id' => $clinica->id,
            'medico_id' => $medico->id,
            'paciente_id' => $paciente->id,
            'data_hora_inicio' => Carbon::now()->addHours(5),
            'data_hora_fim' => Carbon::now()->addHours(5)->addMinutes(30),
            'status' => 'agendada',
            'valor' => 200.00,
        ]);

        $exitCode = Artisan::call('consultas:enviar-lembretes');
        $this->assertEquals(0, $exitCode);

        Queue::assertPushed(EnviarNotificacaoWhatsAppJob::class);
    }
}
