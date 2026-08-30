@extends('layouts.base')

@section('title', 'Painel Backoffice SuperAdmin SaaS')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Painel Global SuperAdmin</h3>
        <p class="text-muted fs-14 m-0">Visão executiva de faturamento, clínicas ativas e saúde do SaaS</p>
    </div>
    <div>
        <span class="badge bg-purple-100 text-purple-800 border border-purple-300 px-3 py-2 fs-13 fw-bold">
            <i class="bi bi-shield-lock-fill text-purple-600 me-1"></i> Acesso Superuser
        </span>
    </div>
</div>

<!-- METRICS CARDS (MRR & ARR & SAAS HEALTH) -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4 bg-emerald-600 text-white" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
            <span class="text-emerald-100 fs-12 fw-bold text-uppercase">MRR (Mensal Recorrente)</span>
            <div class="fs-2 fw-extrabold my-1">R$ {{ number_format($mrr, 2, ',', '.') }}</div>
            <span class="fs-12 text-emerald-200"><i class="bi bi-graph-up-arrow me-1"></i> Receita Recorrente</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-custom p-4 bg-slate-900 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <span class="text-slate-400 fs-12 fw-bold text-uppercase">ARR (Anual Projetado)</span>
            <div class="fs-2 fw-extrabold my-1 text-emerald-400">R$ {{ number_format($arr, 2, ',', '.') }}</div>
            <span class="fs-12 text-slate-400"><i class="bi bi-pie-chart-fill me-1"></i> Previsão Anual</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-custom p-4">
            <span class="text-slate-500 fs-12 fw-bold text-uppercase">Clínicas Cadastradas</span>
            <div class="fs-2 fw-extrabold text-slate-900 my-1">{{ $totalClinicas }}</div>
            <div class="d-flex gap-2 fs-12">
                <span class="text-emerald-600 fw-bold">{{ $clinicasAtivas }} Ativas</span>
                <span class="text-muted">•</span>
                <span class="text-amber-600 fw-bold">{{ $clinicasTrial }} Trial</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-custom p-4">
            <span class="text-slate-500 fs-12 fw-bold text-uppercase">Volume da Plataforma</span>
            <div class="fs-2 fw-extrabold text-blue-600 my-1">{{ number_format($totalConsultas, 0, ',', '.') }}</div>
            <span class="fs-12 text-slate-500"><i class="bi bi-people-fill me-1"></i> {{ $totalPacientes }} Pacientes Atendidos</span>
        </div>
    </div>
</div>

<!-- LATEST CLINICS & PLAN DISTRIBUTION -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-extrabold text-slate-900 m-0">Últimas Clínicas Cadastradas</h5>
                <a href="{{ route('superadmin.clinicas') }}" class="btn btn-sm btn-outline-emerald fw-bold">Ver Todas</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-slate-50">
                        <tr>
                            <th>Clínica</th>
                            <th>CNPJ</th>
                            <th>Responsável</th>
                            <th>Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasClinicas as $clinica)
                        <tr>
                            <td>
                                <div class="fw-bold text-slate-900">{{ $clinica->nome }}</div>
                                <small class="text-muted font-monospace">{{ $clinica->slug }}.saas.com</small>
                            </td>
                            <td class="font-monospace fs-13">{{ $clinica->cnpj ?? 'N/D' }}</td>
                            <td>{{ $clinica->user->name ?? 'Admin' }}</td>
                            <td class="fs-13 text-muted">{{ $clinica->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Nenhuma clínica registrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom p-4">
            <h5 class="fw-extrabold text-slate-900 mb-3">Distribuição por Plano</h5>
            <div class="d-flex flex-column gap-3">
                @foreach($planosMaisVendidos as $plano)
                <div class="p-3 border rounded-3 bg-slate-50">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-extrabold text-slate-900">{{ $plano->nome }}</span>
                        <span class="badge bg-emerald-100 text-emerald-800 fw-bold">R$ {{ number_format($plano->preco_mensal ?? $plano->preco, 2, ',', '.') }}/mês</span>
                    </div>
                    <div class="fs-13 text-muted">
                        <i class="bi bi-building me-1"></i> {{ $plano->assinaturas_count }} clínica(s) assinante(s)
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
