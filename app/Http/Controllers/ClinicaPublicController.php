<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Jobs\EnviarNotificacaoWhatsAppJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClinicaPublicController extends Controller
{
    public function show(string $slug)
    {
        $clinica = Clinica::where('slug', $slug)
            ->orWhere('custom_domain', $slug)
            ->firstOrFail();

        $recepcionistas = \App\Models\User::where('clinica_id', $clinica->id)
            ->where('role', 'recepcionista')
            ->get();

        return view('clinicas.public_landing', compact('clinica', 'recepcionistas'));
    }

    public function agendar(string $slug, Request $request)
    {
        $clinica = Clinica::where('slug', $slug)
            ->orWhere('custom_domain', $slug)
            ->firstOrFail();

        $request->validate([
            'paciente_nome' => 'required|string|max:255',
            'paciente_cpf' => 'required|string|max:14',
            'paciente_telefone' => 'required|string|max:20',
            'medico_id' => 'required|exists:medicos,id',
            'data_consulta' => 'required|date|after_or_equal:today',
            'horario_consulta' => 'required|string',
            'observacoes' => 'nullable|string|max:500',
        ]);

        // Valida se o médico pertence a esta clínica
        $medico = Medico::where('id', $request->medico_id)
            ->where('clinica_id', $clinica->id)
            ->firstOrFail();

        // Limpa CPF e Telefone
        $cpfLimpo = preg_replace('/\D/', '', $request->paciente_cpf);
        $telefoneLimpo = preg_replace('/\D/', '', $request->paciente_telefone);

        // Encontra ou cria paciente para esta clínica
        $paciente = Paciente::where('clinica_id', $clinica->id)
            ->where('cpf', $cpfLimpo)
            ->first();

        if (!$paciente) {
            $paciente = Paciente::create([
                'clinica_id' => $clinica->id,
                'nome' => $request->paciente_nome,
                'cpf' => $cpfLimpo,
                'telefone' => $telefoneLimpo,
                'endereco' => $request->paciente_endereco ?? 'Não informado (Agendamento Online)',
                'email' => $request->paciente_email ?? null,
                'data_nascimento' => $request->paciente_data_nascimento ?? '2000-01-01',
            ]);
        }

        $dataHoraInicio = \Carbon\Carbon::parse($request->data_consulta . ' ' . $request->horario_consulta);
        $dataHoraFim = (clone $dataHoraInicio)->addMinutes(30);

        // Verifica conflito de horário
        $conflito = Consulta::where('clinica_id', $clinica->id)
            ->where('medico_id', $medico->id)
            ->where('data_hora_inicio', $dataHoraInicio)
            ->whereIn('status', ['agendada', 'confirmada'])
            ->exists();

        if ($conflito) {
            return redirect()->back()->withInput()->with('error', 'O horário selecionado não está mais disponível. Por favor, escolha outro horário.');
        }

        // Cria a consulta
        $consulta = Consulta::create([
            'clinica_id' => $clinica->id,
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'data_hora_inicio' => $dataHoraInicio,
            'data_hora_fim' => $dataHoraFim,
            'status' => 'agendada',
            'pago' => '0',
            'valor' => $medico->valor_consulta ?? 150.00,
            'observacoes' => $request->observacoes,
        ]);

        // Dispara notificação via WhatsApp em background
        try {
            $dataFormatted = \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y \à\s H:i');
            $mensagem = "Olá {$paciente->nome}! Sua consulta na clínica {$clinica->nome} foi agendada para {$dataFormatted} com {$medico->nome}.";
            EnviarNotificacaoWhatsAppJob::dispatch($paciente->telefone, $mensagem, $clinica->id);
        } catch (\Exception $e) {
            Log::warning('Falha ao agendar job de notificação de agendamento público: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Sua consulta foi agendada com sucesso! Enviamos a confirmação e instruções para o seu WhatsApp.');
    }
}
