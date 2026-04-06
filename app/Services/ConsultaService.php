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
use Illuminate\Support\Facades\DB;
use App\Services\WhatsAppService;
use App\Models\Clinica;


class ConsultaService
{
    protected WhatsAppService $whatsAppService;
    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }
    protected function validarConflitos(array $dados, ?Consulta $consulta = null): void
    {
        $dataInicio = \Carbon\Carbon::parse($dados['data_hora_inicio']);
        $dataFim = \Carbon\Carbon::parse($dados['data_hora_fim']);
        $clinicaId = Auth::user()->clinica_id;

        if ($dataInicio < now() || $dataFim < now()) {
            abort(422, 'A data e hora da consulta devem ser futuras.');
        }
        if ($dataInicio->diffInMinutes($dataFim) < 10) {
            throw new Exception('Consulta muito curta.');
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
        if (empty($dados['convenio_id'])) {
            return $dados['valor'];
        }
        $convenio = Convenio::find($dados['convenio_id']);

        if (!$convenio) {
            abort(403, 'Dados inválidos para esta clínica.');
        }

        $precoBase = $dados['valor'];
        $percentual_desconto = $convenio->percentual_desconto / 100;

        return round($precoBase * (1 - $percentual_desconto), 2);
    }
    public function criarConsulta(array $dados): Consulta
    {
        
        return DB::transaction(function () use ($dados) {
            $clinica = Clinica::find(Auth::user()->clinica_id);
            $this->validarConflitos($dados);

            $dados['valor'] = $this->calcularPreco($dados);

            $Consulta = Consulta::create($dados);
            if(!$Consulta){
                throw new Exception('Erro ao criar consulta.');
            }else{


                $mensagem = "Olá {$Consulta->paciente->nome}, sua consulta com o Dr. {$dados['medico_id']} foi agendada para o dia {$dados['data_hora_inicio']}, no valor de R$ {$dados['valor']}.
                endereço da clínica: {$clinica->endereco}. Por favor, chegue com 15 minutos de antecedência. Obrigado!";

            
            }    $this->whatsAppService->sendMessage($Consulta->paciente->telefone, $mensagem);
        });

    }
    public function atualizarConsulta(Consulta $consulta, array $dados): Consulta
    {
        $this->validarConflitos($dados, $consulta);
        $dados['valor'] = $this->calcularPreco($dados);
        $consulta->update($dados);
        return $consulta;
    }
    public function confirmarPagamento(Consulta $consulta): Consulta
    {
        $consulta->update(['pago' => 1]);
        return $consulta;
    }
    public function alterarStatus(Consulta $consulta, string $status): Consulta
    {
        if (!in_array($status, ['agendada', 'confirmada', 'realizada', 'cancelada', 'faltou'])) {
            throw new Exception('Status inválido');
        }
        $consulta->update(['status' => $status]);
        return $consulta;
    }

    public function excluirConsulta(Consulta $consulta): void
    {

        $consulta->delete();
    }
    public function listarConsultas(array $filtros = [])
    {
        $query = Consulta::with(['paciente', 'medico', 'convenio'])
            ->where('clinica_id', Auth::user()->clinica_id);

        if (!empty($filtros['data_inicio'])) {
            $query->whereDate('data_hora_inicio', '>=', Carbon::parse($filtros['data_inicio'])->startOfDay());
        }
        if (!empty($filtros['data_fim'])) {
            $query->whereDate('data_hora_inicio', '<=', Carbon::parse($filtros['data_fim'])->endOfDay());
        }
        if (!empty($filtros['medico_id'])) {
            $query->where('medico_id', $filtros['medico_id']);
        }
        if (!empty($filtros['paciente_id'])) {
            $query->where('paciente_id', $filtros['paciente_id']);
        }
        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        return $query->orderBy('data_hora_inicio')->get();
    }
}