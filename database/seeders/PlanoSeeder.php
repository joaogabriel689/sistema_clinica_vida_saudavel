<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    public function run(): void
    {
        $planos = [
            [
                'id' => 1,
                'nome' => 'Starter',
                'slug' => 'starter',
                'descricao' => 'Para consultórios individuais',
                'preco_mensal' => 149.00,
                'max_medicos' => 1,
                'max_recepcionistas' => 1,
                'max_consultas_mes' => 100,
                'ativo' => true,
            ],
            [
                'id' => 2,
                'nome' => 'Clínica Pro',
                'slug' => 'pro',
                'descricao' => 'Para clínicas em crescimento',
                'preco_mensal' => 299.00,
                'max_medicos' => 5,
                'max_recepcionistas' => 3,
                'max_consultas_mes' => 9999,
                'ativo' => true,
            ],
            [
                'id' => 3,
                'nome' => 'Enterprise',
                'slug' => 'enterprise',
                'descricao' => 'Para redes e centros médicos',
                'preco_mensal' => 599.00,
                'max_medicos' => 999,
                'max_recepcionistas' => 999,
                'max_consultas_mes' => 99999,
                'ativo' => true,
            ],
        ];

        foreach ($planos as $plano) {
            Plano::updateOrCreate(['id' => $plano['id']], $plano);
        }
    }
}
