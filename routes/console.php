<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\AuditoriaModel;
use App\Services\ConsultaService;
use App\Services\WhatsAppService;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    $consultaService = app()->make(ConsultaService::class);
    $whatsAppService = app()->make(WhatsAppService::class);

    $consultasamanha = $consultaService->listarConsultas([
        'data_hora_inicio' => now()->addDay()->startOfDay(),
        'data_hora_fim' => now()->addDay()->endOfDay(),
        'status' => 'agendada',

    ]);

    foreach ($consultasamanha as $consulta) {
        $paciente = Paciente::find($consulta->paciente_id);
        $whatsAppService->sendMessage($paciente->telefone, "Lembrete: Você tem uma consulta agendada para amanhã às {$consulta->data_hora_inicio}
        Por favor, confirme sua presença respondendo a esta mensagem.");
    }
    
})->dailyAt('08:00');

Schedule::call(function () {
    $consultaService = app()->make(ConsultaService::class);
    $whatsAppService = app()->make(WhatsAppService::class);

    $consultasHoje = $consultaService->listarConsultas([
        'data_hora_inicio' => now()->startOfDay(),
        'data_hora_fim' => now()->endOfDay(),
        'status' => 'agendada',
    ]);

    foreach ($consultasHoje as $consulta) {
        $paciente = Paciente::find($consulta->paciente_id);
        $whatsAppService->sendMessage($paciente->telefone, "Lembrete: Você tem uma consulta agendada para hoje às {$consulta->data_hora_inicio}
        Por favor, confirme sua presença respondendo a esta mensagem.");
    }
    
})->dailyAt('08:00');

Schedule::call(function(){
    $consultaService = app()->make(ConsultaService::class);
    $whatsAppService = app()->make(WhatsAppService::class);

    $medicos = Medico::all();
    foreach($medicos as $medico){
        $consultas = $consultaService->listarConsultas([
            'data_hora_inicio' => now()->startOfDay(),
            'data_hora_fim' => now()->endOfDay(),
            'status' => 'agendada',
            'medico_id' => $medico->id,
        ]);
        $msg = "Lembrete: Você tem ".count($consultas)." consultas agendadas para hoje.";
        foreach($consultas as $consulta){
            $msg .= "\n- Consulta com {$consulta->paciente->nome} às {$consulta->data_hora_inicio}";

        }
        $whatsAppService->sendMessage($medico->telefone, $msg);
    }

})->dailyAt('07:00');

Schedule::call(function(){
    $auditoriasExcluidas = AuditoriaModel::where(
        'created_at',
        '<',
        now()->subDays(180)
    )->delete();

})->monthlyOn(6, '00:00');

