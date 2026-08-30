<?php

namespace Tests\Feature;

use App\Models\Clinica;
use App\Models\User;
use App\Models\Medico;
use App\Models\Especialidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicaPublicPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_public_clinic_landing_page_with_customization_and_receptionists(): void
    {
        $user = User::factory()->create();
        $clinica = Clinica::create([
            'nome' => 'Clínica Vida Saudável Teste',
            'endereco' => 'Av. Paulista 1000',
            'telefone' => '11999998888',
            'cnpj' => '12.345.678/0001-99',
            'slug' => 'clinica-vida-saudavel-teste',
            'cor_primaria' => '#2563eb',
            'descricao' => 'Atendimento humanizado de alta qualidade',
            'user_id' => $user->id,
        ]);

        $recepcionista = User::create([
            'name' => 'Mariana Recepcionista',
            'email' => 'mariana@clinica.com',
            'password' => bcrypt('password123'),
            'role' => 'recepcionista',
            'telefone' => '11988887777',
            'clinica_id' => $clinica->id,
        ]);

        $response = $this->get('/c/clinica-vida-saudavel-teste');

        $response->assertStatus(200);
        $response->assertSee('Clínica Vida Saudável Teste');
        $response->assertSee('Mariana Recepcionista');
        $response->assertSee('11988887777');
        $response->assertSee('Atendimento humanizado de alta qualidade');
        $response->assertSee('https://wa.me/5511988887777', false);
    }

    public function test_patient_can_schedule_online_appointment(): void
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->create();
        $clinica = Clinica::create([
            'nome' => 'Clínica Odonto Teste',
            'endereco' => 'Rua Augusta 500',
            'telefone' => '11977776666',
            'cnpj' => '98.765.432/0001-11',
            'slug' => 'clinica-odonto-teste',
            'user_id' => $user->id,
        ]);

        $esp = Especialidade::create(['nome' => 'Odontologia']);
        $medicoUser = User::factory()->create(['role' => 'medico']);

        $medico = Medico::create([
            'clinica_id' => $clinica->id,
            'user_id' => $medicoUser->id,
            'especialidade_id' => $esp->id,
            'nome' => 'Dra. Ana Santos',
            'crm' => 'CRO/SP 654321',
            'telefone' => '11977778888',
            'horario_inicio' => '08:00',
            'horario_fim' => '18:00',
        ]);

        $dataConsulta = date('Y-m-d', strtotime('+2 days'));

        $response = $this->post('/c/clinica-odonto-teste/agendar', [
            'paciente_nome' => 'João Paciente',
            'paciente_cpf' => '123.456.789-00',
            'paciente_telefone' => '11955554444',
            'medico_id' => $medico->id,
            'data_consulta' => $dataConsulta,
            'horario_consulta' => '14:00',
            'observacoes' => 'Consulta de rotina',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('consultas', [
            'clinica_id' => $clinica->id,
            'medico_id' => $medico->id,
            'status' => 'agendada',
        ]);

        $this->assertDatabaseHas('pacientes', [
            'clinica_id' => $clinica->id,
            'cpf' => '12345678900',
            'nome' => 'João Paciente',
        ]);
    }
}
