@extends('layouts.base')

@section('title', 'Detalhes da Recepcionista')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Detalhes da Recepcionista</h3>
        <p class="text-muted fs-14 m-0">Informações cadastrais e permissões de acesso</p>
    </div>
    
    <div>
        <a href="{{ route('admin.recepcionistas') }}" class="btn btn-outline-secondary font-semibold">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
        </a>
        <a href="{{ route('admin.recepcionistas.edit', $recepcionista->id) }}" class="btn btn-emerald ms-2">
            <i class="bi bi-pencil-fill me-1"></i> Editar
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-custom p-4 text-center">
            <div class="mx-auto mb-3 text-emerald-600 bg-emerald-50 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-1 shadow-sm" style="width: 80px; height: 80px;">
                {{ strtoupper(substr($recepcionista->name, 0, 1)) }}
            </div>
            <h4 class="fw-bold text-slate-900 mb-1">{{ $recepcionista->name }}</h4>
            <p class="text-muted fs-14 mb-3">{{ $recepcionista->email }}</p>

            <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-1 fs-12 fw-bold">
                Recepcionista Ativa
            </span>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-custom p-4">
            <h5 class="fw-bold text-slate-900 mb-3"><i class="bi bi-person-badge text-emerald-600 me-2"></i>Informações Gerais</h5>

            <table class="table align-middle">
                <tbody>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold" style="width: 200px;">ID do Usuário</th>
                        <td class="font-monospace text-slate-700">#REC-{{ $recepcionista->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">Nome Completo</th>
                        <td class="fw-bold text-slate-900">{{ $recepcionista->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">E-mail de Acesso</th>
                        <td class="text-slate-800">{{ $recepcionista->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">Função no Sistema</th>
                        <td><span class="badge bg-slate-100 text-slate-700 border fs-12">Recepcionista</span></td>
                    </tr>
                    <tr>
                        <th class="text-muted fs-13 text-uppercase fw-semibold">Data de Cadastro</th>
                        <td class="text-slate-700">{{ \Carbon\Carbon::parse($recepcionista->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
