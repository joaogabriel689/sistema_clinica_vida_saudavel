<?php

namespace App\Services;
use App\Models\Consulta;
use Carbon\Carbon;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Convenio;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\http\RedirectResponse;
use Exception;



class ConsultaService
{

    protected function validarConflitos(array $dados, ?Consulta $consulta = null): void
    {
        $dataInicio = \Carbon\Carbon::parse($dados['data_hora_inicio']);
        $dataFim = \Carbon\Carbon::parse($dados['data_hora_fim']);
        $clinicaId = Auth::user()->clinica_id;

        if ($dataInicio < now() || $dataFim < now()) {
            abort(422, 'A data e hora da consulta devem ser futuras.');
        }

        /*
        |----------------------------------------
        | VALIDA MÉDICO E PACIENTE
        |----------------------------------------
        */

        $medico = Medico::where('id', $dados['medico_id'])
            ->where('clinica_id', $clinicaId)
            ->first();

        $paciente = Paciente::where('id', $dados['paciente_id'])
            ->where('clinica_id', $clinicaId)
            ->first();

        if (!$medico || !$paciente) {
            abort(403, 'Dados inválidos para esta clínica.');
        }

        /*
        |----------------------------------------
        | VALIDA HORÁRIO DO MÉDICO
        |----------------------------------------
        */

        if (
            $dataInicio->format('H:i') < $medico->horario_inicio ||
            $dataFim->format('H:i') > $medico->horario_fim
        ) {
            abort(422, 'Fora do horário de atendimento do médico.');
        }

        /*
        |----------------------------------------
        | CONFLITO DO MÉDICO
        |----------------------------------------
        */

        $conflitoMedico = Consulta::where('clinica_id', $clinicaId)
            ->where('medico_id', $dados['medico_id'])
            ->when($consulta, fn ($q) => $q->where('id', '!=', $consulta->id))
            ->where(function ($query) use ($dataInicio, $dataFim) {

                $query->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                    ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                    ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                        $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                    });

            })
            ->exists();

        if ($conflitoMedico) {
            abort(422, 'O médico já possui consulta nesse horário.');
        }

        /*
        |----------------------------------------
        | CONFLITO DO PACIENTE
        |----------------------------------------
        */

        $conflitoPaciente = Consulta::where('clinica_id', $clinicaId)
            ->where('paciente_id', $dados['paciente_id'])
            ->when($consulta, fn ($q) => $q->where('id', '!=', $consulta->id))
            ->where(function ($query) use ($dataInicio, $dataFim) {

                $query->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                    ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                    ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                        $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                    });

            })
            ->exists();

        if ($conflitoPaciente) {
            abort(422, 'O paciente já possui consulta nesse horário.');
        }
    }
    protected function calcularPreco(array $dados): float
    {
        $especialidade = Especialidade::find($dados['especialidade_id']);
        $convenio = Convenio::find($dados['convenio_id']);

        if (!$especialidade || !$convenio) {
            abort(403, 'Dados inválidos para esta clínica.');
        }

        $precoBase = $especialidade->preco_consulta;
        $desconto = $convenio->desconto / 100;

        return round($precoBase * (1 - $desconto), 2);
    }
    public function criarConsulta(array $dados): Consulta
    {
        $this->validarConflitos($dados);
        $dados['preco'] = $this->calcularPreco($dados);
        return Consulta::create($dados);
    }

    public function atualizarConsulta(Consulta $consulta, array $dados): Consulta
    {
        $this->validarConflitos($dados, $consulta);
        $dados['preco'] = $this->calcularPreco($dados);
        $consulta->update($dados);
        return $consulta;
    }

    public function excluirConsulta(Consulta $consulta): void
    {
        
        $consulta->delete();
    }
}