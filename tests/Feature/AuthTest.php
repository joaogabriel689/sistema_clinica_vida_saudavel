<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clinica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'email' => 'admin@teste.com',
            'password' => bcrypt('senha123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/store_login', [
            'email' => 'admin@teste.com',
            'password' => 'senha123',
        ]);

        $response->assertRedirect(route('admin.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $this->withoutMiddleware();

        User::factory()->create([
            'email' => 'admin@teste.com',
            'password' => bcrypt('senha123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/store_login', [
            'email' => 'admin@teste.com',
            'password' => 'senha_errada',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_user_can_register_new_clinic_and_account(): void
    {
        $this->withoutMiddleware();

        $response = $this->post('/store_register', [
            'name' => 'Dr. João Silva',
            'email' => 'joao@clinica.com',
            'password' => 'senha123',
            'nome' => 'Clínica Silva',
            'endereco' => 'Rua Teste 123',
            'telefone' => '11999999999',
            'cnpj' => '12.345.678/0001-00',
        ]);

        $response->assertRedirect(route('dashboard_split'));
        $this->assertDatabaseHas('users', ['email' => 'joao@clinica.com']);
        $this->assertDatabaseHas('clinicas', ['cnpj' => '12.345.678/0001-00']);
    }
}
