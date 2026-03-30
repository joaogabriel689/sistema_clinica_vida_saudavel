<?php

namespace App\Services;

use App\Models\Medico;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Especialidade;
use Illuminate\Support\Facades\DB;


class MedicoService
{
    public function criarMedico(array $dados): Medico
    {
        $id_clinica = Auth::user()->clinica_id;
        DB::transaction(function () use ($id_clinica, $dados) {

            // Cria o usuário do médico
            $user = User::create([
                'name' => $dados['nome'],
                'email' => $dados['email'],
                'password' => Hash::make($dados['password']),
                'role' => 'medico',
                'clinica_id' => $id_clinica,
            ]);

            // Verifica se o usuário selecionou "Outra especialidade"
            if ($dados['especialidade'] === 'outra') {

                // Cria ou encontra a especialidade
                $especialidade = Especialidade::firstOrCreate([
                    'nome' => $dados['nova_especialidade']  
                ]);

                $especialidadeId = $especialidade->id;

            } else {

                // Usa a especialidade selecionada
                $especialidadeId = $dados['especialidade'];
            }

            // Cria o médico
            Medico::create([
                'nome' => $dados['nome'],
                'crm' => $dados['crm'],
                'especialidade_id' => $especialidadeId,
                'telefone' => $dados['telefone'],
                'user_id' => $user->id,
                'clinica_id' => $id_clinica,
                'horario_inicio' => $dados['hora_inicio'],
                'horario_fim' => $dados['hora_fim'],
            ]);
        });
        return Medico::where('crm', $dados['crm'])->where('clinica_id', $id_clinica)->firstOrFail();
    }

    public function atualizarMedico(Medico $medico, array $dados): Medico
    {
        // Transaction para garantir integridade
        DB::transaction(function () use ($dados, $medico) {


            
            // Atualiza o email do usuário relacionado ao médico
            $user = User::find($medico->user_id);

            $user->update([
                'name' => $dados['nome'],
                'email' => $dados['email']
            ]);

            // Verifica se selecionou "outra especialidade"
            if ($dados['especialidade'] === 'outra') {

                $especialidade = Especialidade::firstOrCreate([
                    'nome' => $dados['nova_especialidade']
                ]);

                $especialidadeId = $especialidade->id;

            } else {

                $especialidadeId = $dados['especialidade'];

            }

            // Atualiza os dados do médico
            $medico->update([
                'nome' => $dados['nome'],
                'crm' => $dados['crm'],
                'especialidade_id' => $especialidadeId,
                'horario_inicio' => $dados['hora_inicio'],
                'horario_fim' => $dados['hora_fim'],
            ]);

        });


        return $medico;
    }
}