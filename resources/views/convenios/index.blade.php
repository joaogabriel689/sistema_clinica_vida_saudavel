{{-- ==========================================
     convenios/index.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Convênios')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Convênios</h2>
        <p>Gerencie os planos de saúde e convênios</p>
    </div>
    <a href="{{ route('admin.convenios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Novo Convênio
    </a>
</div>

{{-- SEARCH --}}
<div class="card mb-4 fade-in fade-in-1">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.convenios.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:9px 0 0 9px;border:1.5px solid #e5e7eb;border-right:none;background:#f9fafb;">
                            <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Buscar convênio..."
                               value="{{ request('search') }}"
                               style="border-left:none;border-radius:0 9px 9px 0;">
                    </div>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button class="btn btn-primary">Buscar</button>
                    <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if($convenios->isEmpty())
    <div class="card fade-in fade-in-2">
        <div class="card-body text-center py-5">
            <i class="bi bi-shield-x" style="font-size:36px;color:#d1d5db;display:block;margin-bottom:12px;"></i>
            <p class="text-muted mb-3">Nenhum convênio cadastrado.</p>
            <a href="{{ route('admin.convenios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Cadastrar Convênio
            </a>
        </div>
    </div>
@else
    <div class="card fade-in fade-in-2">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span>Total: <strong>{{ $convenios->total() }}</strong> convênios</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Convênio</th>
                            <th>Código</th>
                            <th>Desconto</th>
                            <th class="text-end" style="width:160px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($convenios as $convenio)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:13.5px;">{{ $convenio->nome }}</div>
                            </td>
                            <td>
                                <span class="badge" style="background:#f3f4f6;color:#374151;font-weight:600;">
                                    {{ $convenio->codigo ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" style="background:#f0fdf4;color:#166534;">
                                    {{ $convenio->percentual_desconto ?? 0 }}%
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.convenios.edit', $convenio->id) }}"
                                   class="btn btn-sm btn-outline-primary me-1">
                                   <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.convenios.destroy', $convenio->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Excluir este convênio?')">
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
        @if($convenios->hasPages())
        <div class="card-footer bg-transparent border-top px-4 py-3" style="border-color:#f0f3f7!important;">
            {{ $convenios->withQueryString()->links() }}
        </div>
        @endif
    </div>
@endif

@endsection


{{-- ==========================================
     NOTE: create & edit below (separate files)
=========================================== --}}