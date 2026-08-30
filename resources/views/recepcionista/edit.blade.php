@extends('layouts.base')

@section('title', 'Editar Recepcionista')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Editar Recepcionista</h3>
        <p class="text-muted fs-14 m-0">Atualize as credenciais e dados da recepcionista</p>
    </div>
    
    <div>
        <a href="{{ route('admin.recepcionistas') }}" class="btn btn-outline-secondary font-semibold">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>
</div>

<div class="card-custom p-4 max-w-2xl mx-auto">
    <form action="{{ route('admin.recepcionistas.update', $recepcionista->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold text-slate-700 fs-14">Nome Completo</label>
            <input type="text" name="nome" class="form-control form-control-custom" value="{{ old('nome', $recepcionista->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-slate-700 fs-14">E-mail</label>
            <input type="email" name="email" class="form-control form-control-custom" value="{{ old('email', $recepcionista->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-slate-700 fs-14">Telefone / WhatsApp</label>
            <input type="text" name="telefone" class="form-control form-control-custom" value="{{ old('telefone', $recepcionista->telefone) }}" placeholder="(11) 99999-9999">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold text-slate-700 fs-14">Nova Senha <small class="text-muted fw-normal">(Deixe em branco para não alterar)</small></label>
            <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••">
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.recepcionistas') }}" class="btn btn-slate-100 text-slate-600 font-semibold">Cancelar</a>
            <button type="submit" class="btn btn-emerald px-4 fw-bold">
                <i class="bi bi-check-lg me-1"></i> Salvar Alterações
            </button>
        </div>
    </form>
</div>

@endsection
