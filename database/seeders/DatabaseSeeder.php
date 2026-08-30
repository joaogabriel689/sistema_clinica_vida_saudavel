<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Plano;
use App\Models\Assinatura;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanoSeeder::class,
        ]);

        // Cria Administrador Padrão da Clínica
        $admin = User::firstOrCreate(
            ['email' => 'admin@clinica.com'],
            [
                'name' => 'Administrador da Clínica',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'telefone' => '11999998888',
            ]
        );

        // Cria Clínica Principal
        $clinica = Clinica::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'nome' => 'Clínica Vida Saudável',
                'endereco' => 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP',
                'telefone' => '11999998888',
                'cnpj' => '12.345.678/0001-99',
                'slug' => 'clinica-vida-saudavel',
                'cor_primaria' => '#059669',
                'descricao' => 'Atendimento médico especializado de alta qualidade com agendamento e suporte humanizado.',
            ]
        );

        $admin->update(['clinica_id' => $clinica->id]);

        // Assinatura de Plano Ativa (Pro)
        Assinatura::firstOrCreate(
            ['clinica_id' => $clinica->id],
            [
                'plano_id' => 2, // Pro
                'status' => 'ativa',
                'proxima_cobranca' => now()->addDays(30),
                'gateway' => 'asaas',
            ]
        );

        // Cria Recepcionista Padrão
        User::firstOrCreate(
            ['email' => 'recepcao@clinica.com'],
            [
                'name' => 'Mariana Recepcionista',
                'password' => Hash::make('password123'),
                'role' => 'recepcionista',
                'telefone' => '11988887777',
                'clinica_id' => $clinica->id,
            ]
        );

        // Cria Médico Padrão
        $medicoUser = User::firstOrCreate(
            ['email' => 'medico@clinica.com'],
            [
                'name' => 'Dr. Carlos Silva',
                'password' => Hash::make('password123'),
                'role' => 'medico',
                'telefone' => '11977776666',
                'clinica_id' => $clinica->id,
            ]
        );

        $especialidade = \App\Models\Especialidade::firstOrCreate(['nome' => 'Clínica Geral']);

        \App\Models\Medico::firstOrCreate(
            ['user_id' => $medicoUser->id],
            [
                'clinica_id' => $clinica->id,
                'especialidade_id' => $especialidade->id,
                'nome' => 'Dr. Carlos Silva',
                'crm' => 'CRM/SP 123456',
                'telefone' => '11977776666',
                'horario_inicio' => '08:00',
                'horario_fim' => '18:00',
            ]
        );
    }
}
