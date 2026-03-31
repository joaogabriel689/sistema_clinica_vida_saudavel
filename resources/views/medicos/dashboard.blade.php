{{-- ==========================================
     medico/dashboard.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Painel do Médico')
@section('content')

<div class="fade-in" style="margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="width:54px;height:54px;background:linear-gradient(135deg,#16a34a,#166534);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;flex-shrink:0;">
            {{ strtoupper(substr($medico->nome, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-size:22px;font-weight:800;margin:0;">Olá, Dr(a). {{ $medico->nome }} 👋</h2>
            <p style="color:#6b7280;font-size:13.5px;margin:2px 0 0;">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D [de] MMMM') }}
                — {{ $agenda_medico_hoje->count() }} consulta(s) hoje
            </p>
        </div>
    </div>
</div>

{{-- DADOS DO MÉDICO --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 fade-in fade-in-1">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin-bottom:8px;">CRM</div>
                <div style="font-size:18px;font-weight:800;color:#111827;">{{ $medico->crm ?? '—' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in fade-in-2">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin-bottom:8px;">Especialidade</div>
                <div style="font-size:15px;font-weight:700;color:#111827;">{{ $medico->especialidade->nome ?? '—' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in fade-in-3">
        <div class="metric-card">
            <div class="metric-icon" style="background:#f0fdf4;color:#16a34a;"><i class="bi bi-calendar-check"></i></div>
            <div class="metric-value">{{ $agenda_medico_hoje->count() }}</div>
            <div class="metric-label">Consultas Hoje</div>
        </div>
    </div>
</div>

{{-- AGENDA DO DIA --}}
<div class="card fade-in fade-in-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-calendar-day me-2 text-success"></i>Agenda de Hoje</span>
        <span class="badge" style="background:#f0fdf4;color:#166534;">
            {{ $agenda_medico_hoje->count() }} consultas
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Paciente</th>
                        <th>Status</th>
                        <th style="width:100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agenda_medico_hoje as $consulta)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:34px;height:34px;background:#f0fdf4;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#16a34a;flex-shrink:0;">
                                    {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('H:i') }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:13.5px;">
                                {{ $consulta->paciente->nome ?? 'Não encontrado' }}
                            </div>
                        </td>
                        <td>
                            @if($consulta->status == 'confirmada')
                                <span class="badge bg-success">Confirmada</span>
                            @elseif($consulta->status == 'cancelada')
                                <span class="badge bg-danger">Cancelada</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendente</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('consultas.show', $consulta->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-calendar-x" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:8px;"></i>
                            <span class="text-muted">Nenhuma consulta agendada para hoje</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


{{-- ==========================================
     admin/criar_clinica.blade.php
=========================================== --}}