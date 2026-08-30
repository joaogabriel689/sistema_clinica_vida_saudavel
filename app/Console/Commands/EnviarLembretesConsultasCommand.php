<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consulta;
use App\Jobs\EnviarNotificacaoWhatsAppJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnviarLembretesConsultasCommand extends Command
{
    protected $signature = 'consultas:enviar-lembretes';
    protected $description = 'Envia lembretes automáticos via WhatsApp para consultas agendadas nas próximas 24 horas.';

    public function handle(): int
    {
        $agora = Carbon::now();
        $em24Horas = (clone $agora)->addHours(24);

        $consultas = Consulta::withoutGlobalScopes()
            ->with(['paciente', 'medico', 'clinica'])
            ->whereIn('status', ['agendada', 'confirmada'])
            ->whereBetween('data_hora_inicio', [$agora, $em24Horas])
            ->get();

        $enviados = 0;
        foreach ($consultas as $consulta) {
            if (!$consulta->paciente || !$consulta->paciente->telefone) {
                continue;
            }

            $horarioFormatted = Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y \à\s H:i');
            $mensagem = "⏰ *Lembrete de Consulta*: Olá {$consulta->paciente->nome}! Lembramos que você possui consulta agendada para {$horarioFormatted} com Dr(a). {$consulta->medico->nome} na clínica {$consulta->clinica->nome}.";

            try {
                EnviarNotificacaoWhatsAppJob::dispatch(
                    $consulta->paciente->telefone,
                    $mensagem,
                    $consulta->clinica_id
                );
                $enviados++;
            } catch (\Exception $e) {
                Log::error('Erro ao agendar job de lembrete de consulta: ' . $e->getMessage());
            }
        }

        $this->info("Processamento concluído. {$enviados} lembretes de consulta foram enviados para a fila do WhatsApp.");
        return Command::SUCCESS;
    }
}
