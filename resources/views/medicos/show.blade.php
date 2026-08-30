@extends('layouts.base')

@section('title', 'Perfil do Médico')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Perfil do Médico</h3>
        <p class="text-muted fs-14 m-0">Dados cadastrais, CRM e agenda profissional</p>
    </div>
    
    <div>
        <a href="{{ route('admin.medicos') }}" class="btn btn-outline-secondary font-semibold">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Corpo Médico
        </a>
        <a href="{{ route('admin.medicos.edit', $medico->id) }}" class="btn btn-emerald ms-2">
            <i class="bi bi-pencil-fill me-1"></i> Editar Médico
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-custom p-4 text-center">
            <div class="mx-auto mb-3 text-emerald-600 bg-emerald-50 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-1 shadow-sm" style="width: 80px; height: 80px;">
                <i class="bi bi-person-badge"></i>
            </div>
            <h4 class="fw-bold text-slate-900 mb-1">Dr(a). {{ $medico->nome }}</h4>
            <p class="text-muted fs-14 mb-2">CRM: <span class="font-monospace fw-bold text-slate-800">{{ $medico->crm }}</span></p>

            <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-1 fs-12 fw-bold">
                {{ $medico->especialidade->nome ?? 'Clínica Geral' }}
            </span>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-custom p-4">
            <h5 class="fw-bold text-slate-900 mb-3"><i class="bi bi-clock-history text-emerald-600 me-2"></i>Horários & Agenda</h5>

            <table class="table align-middle">
                <tbody>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold" style="width: 200px;">Especialidade</th>
                        <td class="fw-bold text-slate-900">{{ $medico->especialidade->nome ?? 'Clínica Geral' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">Horário Atendimento</th>
                        <td class="text-slate-800 fw-bold">{{ $medico->horario_inicio ?? '08:00' }} às {{ $medico->horario_fim ?? '18:00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">Clínica Vinculada</th>
                        <td class="text-slate-700">{{ auth()->user()->clinica->nome ?? 'Clínica Vida Saudável' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
