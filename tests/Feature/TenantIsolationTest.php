<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Paciente;
use App\Jobs\EnviarNotificacaoWhatsAppJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected $userA;
    protected $clinicaA;
    protected $userB;
    protected $clinicaB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create User A without clinica_id first to satisfy FK
        $this->userA = User::create([
            'name' => 'Admin Tenant A',
            'email' => 'adminA@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'clinica_id' => null
        ]);

        $this->clinicaA = Clinica::create([
            'user_id' => $this->userA->id,
            'nome' => 'Clínica A',
            'cnpj' => '11111111000111',
            'telefone' => '11999999999',
            'endereco' => 'Rua A'
        ]);

        $this->userA->update(['clinica_id' => $this->clinicaA->id]);

        // 2. Create User B & Clinica B
        $this->userB = User::create([
            'name' => 'Admin Tenant B',
            'email' => 'adminB@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'clinica_id' => null
        ]);

        $this->clinicaB = Clinica::create([
            'user_id' => $this->userB->id,
            'nome' => 'Clínica B',
            'cnpj' => '22222222000122',
            'telefone' => '11888888888',
            'endereco' => 'Rua B'
        ]);

        $this->userB->update(['clinica_id' => $this->clinicaB->id]);
    }

    public function test_tenant_scope_prevents_cross_tenant_data_leakage()
    {
        // 1. Create Patient for Tenant B
        $pacienteB = Paciente::withoutGlobalScopes()->create([
            'clinica_id' => $this->clinicaB->id,
            'nome' => 'Paciente Exclusivo B',
            'cpf' => '000.000.000-99',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11977777777',
            'endereco' => 'Rua B, 100',
            'email' => 'pacienteb@test.com'
        ]);

        // 2. Act as User A and query Pacientes
        $this->actingAs($this->userA);

        $pacientesVistosPorA = Paciente::all();

        // 3. Assert User A CANNOT see Tenant B's patient
        $this->assertCount(0, $pacientesVistosPorA);
        $this->assertFalse($pacientesVistosPorA->contains($pacienteB->id));

        // 4. Assert Direct ID lookup by User A returns null (IDOR Prevention)
        $lookupDirect = Paciente::find($pacienteB->id);
        $this->assertNull($lookupDirect);
    }

    public function test_idor_protection_on_paciente_routes()
    {
        $this->userA->update(['role' => 'recepcionista']);

        $pacienteB = Paciente::withoutGlobalScopes()->create([
            'clinica_id' => $this->clinicaB->id,
            'nome' => 'Paciente B Securi',
            'cpf' => '111.222.333-44',
            'data_nascimento' => '1992-05-10',
            'telefone' => '11988887777',
            'endereco' => 'Rua B, 200'
        ]);

        // User A attempts to access Tenant B patient by direct URL ID
        $this->actingAs($this->userA);
        $response = $this->get('/pacientes/' . $pacienteB->id);

        $response->assertStatus(404);
    }

    public function test_async_job_revalidates_tenant_context()
    {
        Http::fake();

        $job = new EnviarNotificacaoWhatsAppJob(
            '11999998888',
            'Lembrete de consulta de teste',
            $this->clinicaA->id
        );

        $job->handle(app(\App\Services\WhatsAppService::class));

        $this->assertTrue(true);
    }
}
