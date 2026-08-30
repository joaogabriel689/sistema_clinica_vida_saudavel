<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Plano;
use App\Models\Assinatura;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $normalAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create([
            'role' => 'superadmin',
            'email' => 'super@saas.com',
        ]);

        $this->normalAdmin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@clinica.com',
        ]);
    }

    public function test_non_superadmin_cannot_access_superadmin_routes(): void
    {
        $response = $this->actingAs($this->normalAdmin)->get(route('superadmin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_dashboard_and_mrr_metrics(): void
    {
        $plano = Plano::create([
            'nome' => 'Plano Pro',
            'slug' => 'pro',
            'preco_mensal' => 299.00,
            'max_medicos' => 5,
            'max_recepcionistas' => 5,
        ]);

        $clinica = Clinica::create([
            'nome' => 'Clínica SuperTest',
            'endereco' => 'Rua Teste 100',
            'telefone' => '11999991111',
            'cnpj' => '11.111.111/0001-11',
            'slug' => 'clinica-supertest',
            'user_id' => $this->normalAdmin->id,
        ]);

        Assinatura::create([
            'clinica_id' => $clinica->id,
            'plano_id' => $plano->id,
            'status' => 'ativa',
            'proxima_cobranca' => now()->addDays(30),
            'gateway' => 'asaas',
        ]);

        $response = $this->actingAs($this->superAdmin)->get(route('superadmin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Painel Global SuperAdmin');
        $response->assertSee('R$ 299,00');
    }

    public function test_superadmin_can_update_plan_prices_and_limits(): void
    {
        $this->withoutMiddleware();

        $plano = Plano::create([
            'nome' => 'Plano Básico',
            'slug' => 'basico',
            'preco_mensal' => 149.00,
            'max_medicos' => 2,
            'max_recepcionistas' => 2,
        ]);

        $response = $this->actingAs($this->superAdmin)->put(route('superadmin.planos.update', $plano->id), [
            'nome' => 'Plano Básico Premium',
            'preco' => 199.00,
            'limite_medicos' => 4,
            'limite_recepcionistas' => 4,
            'descricao' => 'Plano atualizado com novos valores e limites',
            'ativo' => 1,
        ]);

        $response->assertRedirect(route('superadmin.planos'));

        $plano->refresh();
        $this->assertEquals('Plano Básico Premium', $plano->nome);
        $this->assertEquals(199.00, $plano->preco_mensal);
        $this->assertEquals(4, $plano->max_medicos);
    }

    public function test_superadmin_can_update_clinic_status_and_assigned_plan(): void
    {
        $this->withoutMiddleware();

        $plano = Plano::create([
            'nome' => 'Plano Inicial',
            'slug' => 'inicial',
            'preco_mensal' => 99.00,
            'max_medicos' => 1,
            'max_recepcionistas' => 1,
        ]);

        $clinica = Clinica::create([
            'nome' => 'Clínica Status',
            'endereco' => 'Av Brasil 500',
            'telefone' => '11988882222',
            'cnpj' => '22.222.222/0001-22',
            'slug' => 'clinica-status',
            'user_id' => $this->normalAdmin->id,
        ]);

        $response = $this->actingAs($this->superAdmin)->post(route('superadmin.clinicas.atualizar', $clinica->id), [
            'status' => 'ativa',
            'plano_id' => $plano->id,
        ]);

        $response->assertRedirect();

        $assinatura = Assinatura::withoutGlobalScopes()->where('clinica_id', $clinica->id)->first();
        $this->assertNotNull($assinatura);
        $this->assertEquals('ativa', $assinatura->status);
        $this->assertEquals($plano->id, $assinatura->plano_id);
    }
}
