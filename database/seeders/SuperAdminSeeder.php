<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@saas.com'],
            [
                'name' => 'SuperAdmin SaaS',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'telefone' => '11999998888',
                'clinica_id' => null,
            ]
        );
    }
}
