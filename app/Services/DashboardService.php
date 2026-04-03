<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Clinica;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Medico;
use Illuminate\Support\Facades\DB;
class DashboardService
{
    public function adminDashboard()
    {
        $user = Auth::user();

        $clinica = Clinica::where('user_id', $user->id)->first();

        if (!$clinica) {
            return [
                'clinica' => null,
                'quantidade_convenios' => 0,
                'quantidade_recepcionistas' => 0,
                'quantidade_medicos' => 0,
                'consultas_hoje' => 0,
                'consultas_mes' => 0,
                'faturamento_mes' => 0,
                'novos_pacientes_mes' => 0,
                'ticket_medio' => 0
            ];
        }

        $hoje = now();

        $inicioMes = $hoje->copy()->startOfMonth();
        $fimMes = $hoje->copy()->endOfMonth();

        $consultas_mes_query = $clinica->consultas()
            ->whereBetween('data_hora_inicio', [$inicioMes, $fimMes]);

        $consultas_mes = $consultas_mes_query->count();
        $faturamento_mes = (clone $consultas_mes_query)->sum('valor');
       

        $consultasSemana = DB::table('consultas')
            ->selectRaw('DAYOFWEEK(data_hora_inicio) as dia_semana, COUNT(*) as total')
            ->where('clinica_id', $clinica->id)
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get();
        
        $dias = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
        ];

        foreach ($consultasSemana as $item) {
            $dias[$item->dia_semana] = $item->total;
        }   

        return [
            'clinica' => $clinica,

            'quantidade_convenios' => $clinica->convenios()->count(),

            'quantidade_recepcionistas' => User::where('role', 'recepcionista')
                ->where('clinica_id', $clinica->id)
                ->count(),

            'quantidade_medicos' => User::where('role', 'medico')
                ->where('clinica_id', $clinica->id)
                ->count(),

            'consultas_hoje' => $clinica->consultas()
                ->whereDate('data_hora_inicio', $hoje)
                ->count(),

            'consultas_mes' => $consultas_mes,

            'faturamento_mes' => $faturamento_mes,

            'novos_pacientes_mes' => $clinica->pacientes()
                ->whereBetween('created_at', [$inicioMes, $fimMes])
                ->count(),

            'ticket_medio' => $consultas_mes > 0
                ? $faturamento_mes / $consultas_mes
                : 0,
            'consultas_semana' => $dias
        ];
    }
    public function medicoDashboard(){
        $medico = Medico::where('user_id', Auth::id())->first()->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $agenda_medico_hoje = Consulta::where('medico_id', $medico->id)
            ->whereDate('data_hora_inicio', now()->toDateString())
            ->with('paciente')
            ->orderBy('data_hora_inicio')
            ->get()->where('clinica_id', Auth::user()->clinica_id);

        $proxima_consulta = Consulta::where('medico_id', $medico->id)
            ->where('data_hora_inicio', '>', now())
            ->with('paciente')
            ->orderBy('data_hora_inicio')
            ->first();
        $dados = [
            'agenda_medico_hoje' => $agenda_medico_hoje,
            'proxima_consulta' => $proxima_consulta,
            'medico' => $medico
        ];
        return $dados;
    }
    public function recepcionistaDashboard(){
        // Quantidade total de pacientes cadastrados
        $quantidade_pacientes = Paciente::where('clinica_id', Auth::user()->clinica_id)->count();

        // Quantidade de médicos cadastrados
        $quantidade_medicos = Medico::where('clinica_id', Auth::user()->clinica_id)->count();

        // Quantidade de consultas marcadas para hoje
        $quantidade_consultas_hoje = Consulta::where('clinica_id', Auth::user()->clinica_id)->whereDate(
            'data_hora_inicio',
            now()->toDateString()
        )->count();

        // Últimos 5 pacientes cadastrados
        $pacientes_recentes = Paciente::where('clinica_id', Auth::user()->clinica_id)->latest()
            ->take(5)
            ->get();

        // Consultas de hoje (com médico e paciente)
        $agendas_hoje = Consulta::with(['medico', 'paciente'])
            ->where('clinica_id', Auth::user()->clinica_id)
            ->whereDate('data_hora_inicio', now()->toDateString())
            ->orderBy('data_hora_inicio')
            ->get();

        $dados = [
            'quantidade_pacientes' => $quantidade_pacientes,
            'quantidade_medicos' => $quantidade_medicos,
            'quantidade_consultas_hoje' => $quantidade_consultas_hoje,
            'pacientes_recentes' => $pacientes_recentes,
            'agendas_hoje' => $agendas_hoje
        ];
        return $dados;
    }
}