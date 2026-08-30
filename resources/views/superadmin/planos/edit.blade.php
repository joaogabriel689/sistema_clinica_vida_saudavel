@extends('layouts.base')

@section('title', 'Editar Plano ' . $plano->nome . ' — SuperAdmin')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Editar Plano: {{ $plano->nome }}</h3>
        <p class="text-muted fs-14 m-0">Ajuste os valores de assinatura e limites por clínica cadastrada</p>
    </div>
    
    <a href="{{ route('superadmin.planos') }}" class="btn btn-outline-secondary fw-bold">
        <i class="bi bi-arrow-left me-1"></i> Voltar para Planos
    </a>
</div>

<div class="card-custom p-4 max-w-2xl mx-auto" style="max-width: 650px;">
    <form action="{{ route('superadmin.planos.update', $plano->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold text-slate-700">Nome do Plano</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $plano->nome) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-slate-700">Preço Mensal (R$)</label>
            <div class="input-group">
                <span class="input-group-text font-monospace fw-bold">R$</span>
                <input type="number" step="0.01" name="preco" class="form-control fs-5 fw-extrabold text-emerald-700" value="{{ old('preco', $plano->preco_mensal ?? $plano->preco) }}" required>
            </div>
            <small class="text-muted">Este valor será cobrado via Asaas a cada 30 dias para novas assinaturas.</small>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-slate-700">Limite de Médicos</label>
                <input type="number" name="limite_medicos" class="form-control" value="{{ old('limite_medicos', $plano->max_medicos ?? $plano->limite_medicos) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-slate-700">Limite de Recepcionistas</label>
                <input type="number" name="limite_recepcionistas" class="form-control" value="{{ old('limite_recepcionistas', $plano->max_recepcionistas ?? $plano->limite_recepcionistas) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-slate-700">Descrição do Plano</label>
            <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $plano->descricao) }}</textarea>
        </div>

        <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" name="ativo" id="ativoSwitch" {{ $plano->ativo ? 'checked' : '' }}>
            <label class="form-check-label fw-bold text-slate-800" for="ativoSwitch">Plano Disponível para Contratação</label>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('superadmin.planos') }}" class="btn btn-secondary fw-bold">Cancelar</a>
            <button type="submit" class="btn btn-emerald fw-bold px-4">Salvar Alterações</button>
        </div>
    </form>
</div>

@endsection
