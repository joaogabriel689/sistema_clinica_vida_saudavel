<?php

namespace App\Services;
use App\Models\User;
use App\Models\Clinica;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function criarUsuario(array $dados): User
    {
        $user = User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => Hash::make($dados['password']),
            'role' => 'admin',
        ]);

        $clinica = Clinica::create([
            'nome' => $dados['nome'],
            'endereco' => $dados['endereco'],
            'telefone' => $dados['telefone'],
            'cnpj' => $dados['cnpj'],
            'user_id' => $user->id,
        ]);


        $user->update([
            'clinica_id' => $clinica->id
        ]);
        return $user;
    }

    public function atualizarUsuario(User $user, array $dados): User
    {
        if (isset($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }
        $user->update($dados);
        return $user;
    }
}