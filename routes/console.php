<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Consulta;
use App\Models\Paciente;
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
        $whatsAppService->sendMessage($paciente->telefone, "Lembrete: Você tem uma consulta agendada para amanhã às {$consulta->data_hora_inicio}.");
    }
    
})->dailyAt('08:00');

