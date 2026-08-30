@extends('layouts.base')

@section('title', 'Gestão Global de Clínicas — SuperAdmin')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Gestão Global de Clínicas</h3>
        <p class="text-muted fs-14 m-0">Gerencie o status de assinatura e permissões das clínicas do ecossistema SaaS</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- BUSCA -->
<div class="card-custom p-3 mb-4">
    <form action="{{ route('superadmin.clinicas') }}" method="GET" class="row g-2">
        <div class="col-md-10">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nome da clínica, CNPJ ou slug..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-emerald w-100 fw-bold"><i class="bi bi-search me-1"></i> Buscar</button>
        </div>
    </form>
</div>

<!-- LISTAGEM DE CLÍNICAS -->
<div class="card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-slate-50 border-bottom">
                <tr>
                    <th class="ps-4">Clínica / Subdomínio</th>
                    <th>CNPJ</th>
                    <th>Médicos / Recepcionistas</th>
                    <th>Plano / Status</th>
                    <th class="text-end pe-4">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clinicas as $clinica)
                @php
                    $ass = $assinaturasMap->get($clinica->id);
                @endphp
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-slate-900">{{ $clinica->nome }}</div>
                        <small class="text-emerald-600 font-monospace">{{ $clinica->custom_domain ?? $clinica->slug . '.saas.com' }}</small>
                    </td>
                    <td class="font-monospace fs-13">{{ $clinica->cnpj ?? 'N/D' }}</td>
                    <td>
                        <span class="badge bg-slate-100 text-slate-700 me-1">{{ $clinica->medicos_count ?? $clinica->medicos->count() }} Médicos</span>
                        <span class="badge bg-slate-100 text-slate-700">{{ $clinica->recepcionistas_count ?? $clinica->recepcionistas->count() }} Receps</span>
                    </td>
                    <td>
                        <span class="fw-bold text-slate-800 d-block fs-13">{{ $ass->plano->nome ?? 'Sem Plano' }}</span>
                        <span class="badge {{ ($ass->status ?? '') === 'ativa' ? 'bg-emerald-100 text-emerald-800' : (($ass->status ?? '') === 'trial' ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800') }} px-2 py-1 fs-11">
                            {{ strtoupper($ass->status ?? 'TRIAL') }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal" data-bs-target="#editModal{{ $clinica->id }}">
                            <i class="bi bi-pencil-square me-1"></i> Gerenciar
                        </button>

                        <!-- MODAL DE EDIÇÃO DA CLÍNICA -->
                        <div class="modal fade text-start" id="editModal{{ $clinica->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('superadmin.clinicas.atualizar', $clinica->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Gerenciar {{ $clinica->nome }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Plano de Assinatura</label>
                                                <select name="plano_id" class="form-select">
                                                    @foreach($planos as $plano)
                                                        <option value="{{ $plano->id }}" {{ ($ass->plano_id ?? null) == $plano->id ? 'selected' : '' }}>
                                                            {{ $plano->nome }} — R$ {{ number_format($plano->preco_mensal ?? $plano->preco, 2, ',', '.') }}/mês
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status da Assinatura</label>
                                                <select name="status" class="form-select">
                                                    <option value="ativa" {{ ($ass->status ?? '') === 'ativa' ? 'selected' : '' }}>Ativa (Acesso Liberado)</option>
                                                    <option value="trial" {{ ($ass->status ?? '') === 'trial' ? 'selected' : '' }}>Trial (Período de Testes)</option>
                                                    <option value="inadimplente" {{ ($ass->status ?? '') === 'inadimplente' ? 'selected' : '' }}>Inadimplente (Aviso)</option>
                                                    <option value="suspensa" {{ ($ass->status ?? '') === 'suspensa' ? 'selected' : '' }}>Suspensa (Bloqueio Total)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-emerald fw-bold">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Nenhuma clínica encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $clinicas->links() }}
</div>

@endsection
