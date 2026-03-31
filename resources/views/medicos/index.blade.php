{{-- ==========================================
     medicos/index.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Médicos')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Médicos Cadastrados</h2>
        <p>Gerencie o quadro clínico da unidade</p>
    </div>
    <a href="{{ route('admin.medicos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Cadastrar Médico
    </a>
</div>

<div class="card mb-4 fade-in fade-in-1">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.medicos') }}">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:9px 0 0 9px;border:1.5px solid #e5e7eb;border-right:none;background:#f9fafb;">
                            <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Buscar por nome, CRM ou email..."
                               value="{{ request('search') }}"
                               style="border-left:none;border-radius:0 9px 9px 0;">
                    </div>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button class="btn btn-primary">Buscar</button>
                    <a href="{{ route('admin.medicos') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if($medicos->isEmpty())
    <div class="card fade-in fade-in-2">
        <div class="card-body text-center py-5">
            <i class="bi bi-person-x" style="font-size:36px;color:#d1d5db;display:block;margin-bottom:12px;"></i>
            <p class="text-muted mb-3">Nenhum médico encontrado.</p>
            <a href="{{ route('admin.medicos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Cadastrar Médico
            </a>
        </div>
    </div>
@else
    <div class="card fade-in fade-in-2">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span>Total: <strong>{{ $medicos->total() }}</strong> médicos</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Médico</th>
                            <th>CRM</th>
                            <th>Especialidade</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th class="text-end" style="width:140px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicos as $medico)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:34px;height:34px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#16a34a;flex-shrink:0;">
                                        {{ strtoupper(substr($medico->nome, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:13.5px;">{{ $medico->nome }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background:#f3f4f6;color:#374151;font-weight:600;font-size:11px;">
                                    {{ $medico->crm }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" style="background:#f0fdf4;color:#166534;">
                                    {{ $medico->especialidade->nome ?? '—' }}
                                </span>
                            </td>
                            <td style="font-size:13px;">{{ $medico->telefone }}</td>
                            <td style="font-size:13px;">{{ $medico->user->email }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.medicos.edit', $medico->id) }}"
                                   class="btn btn-sm btn-outline-primary me-1">
                                   <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.medicos.destroy', $medico->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Excluir este médico?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($medicos->hasPages())
        <div class="card-footer bg-transparent border-top px-4 py-3" style="border-color:#f0f3f7!important;">
            {{ $medicos->withQueryString()->links() }}
        </div>
        @endif
    </div>
@endif

@endsection