@extends('layouts.base')

@section('title', 'Gestão de Planos & Preços — SuperAdmin')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Gestão de Planos & Valores</h3>
        <p class="text-muted fs-14 m-0">Cadastre e edite a precificação e os limites dos planos oferecidos no SaaS</p>
    </div>
    
    <button type="button" class="btn btn-emerald fw-bold" data-bs-toggle="modal" data-bs-target="#newPlanModal">
        <i class="bi bi-plus-lg me-1"></i> Criar Novo Plano
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- CARDS DE PLANOS -->
<div class="row g-4 mb-4">
    @foreach($planos as $plano)
    <div class="col-lg-4">
        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between border">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="fw-extrabold text-slate-900 m-0">{{ $plano->nome }}</h4>
                    <span class="badge {{ $plano->ativo ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }} px-2 py-1 fs-11">
                        {{ $plano->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <div class="fs-2 fw-extrabold text-slate-900 mb-3">
                    R$ {{ number_format($plano->preco_mensal ?? $plano->preco, 2, ',', '.') }}
                    <small class="fs-13 text-muted">/mês</small>
                </div>

                <ul class="list-unstyled mb-4 d-flex flex-column gap-2 text-slate-700 fs-14">
                    <li><i class="bi bi-person-badge text-emerald-600 me-2"></i> Limite: <strong>{{ $plano->max_medicos ?? $plano->limite_medicos }} Médicos</strong></li>
                    <li><i class="bi bi-people text-emerald-600 me-2"></i> Limite: <strong>{{ $plano->max_recepcionistas ?? $plano->limite_recepcionistas }} Recepcionistas</strong></li>
                    <li><i class="bi bi-building text-slate-500 me-2"></i> Assinantes Ativos: <strong>{{ $plano->assinaturas_count }} Clínicas</strong></li>
                </ul>

                @if($plano->descricao)
                <p class="text-muted fs-13 border-top pt-2 m-0">{{ $plano->descricao }}</p>
                @endif
            </div>

            <div class="mt-4">
                <a href="{{ route('superadmin.planos.edit', $plano->id) }}" class="btn btn-outline-primary w-100 fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> Editar Preço & Limites
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- MODAL DE CRIAÇÃO DE PLANO -->
<div class="modal fade" id="newPlanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('superadmin.planos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Criar Novo Plano do SaaS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Plano</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: Clínica Enterprise" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Preço Mensal (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" placeholder="499.00" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Limite Médicos</label>
                            <input type="number" name="limite_medicos" class="form-control" value="10" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Limite Recepcionistas</label>
                            <input type="number" name="limite_recepcionistas" class="form-control" value="10" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição dos Benefícios</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Recursos inclusos no plano..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-emerald fw-bold">Salvar e Publicar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
