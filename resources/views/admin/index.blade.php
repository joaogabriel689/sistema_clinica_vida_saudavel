@extends('layouts.base')

@section('title', 'Painel de Controle — Admin')

@section('content')

<style>
.dashboard-hero-banner {
    background: radial-gradient(100% 100% at 50% 0%, #064e3b 0%, #061610 100%);
    border-radius: 20px;
    padding: 32px 36px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 14px 30px -10px rgba(6, 78, 59, 0.3);
    margin-bottom: 32px;
}

.dashboard-hero-banner::after {
    content: '\f473';
    font-family: 'Bootstrap Icons';
    position: absolute;
    right: 36px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 110px;
    opacity: 0.05;
    color: #fff;
    pointer-events: none;
}

.metric-card-glass {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 24px;
    box-shadow: var(--card-shadow);
    transition: all 0.25s var(--ease-spring);
    position: relative;
    overflow: hidden;
}

.metric-card-glass::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 4px;
    background: linear-gradient(90deg, #10b981, #059669);
}

.metric-card-glass:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 36px -12px rgba(16, 185, 129, 0.18);
    border-color: #34d399;
}

.icon-box-emerald {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: #ecfdf5;
    color: #059669;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
}

.icon-box-blue {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
}

.icon-box-amber {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: #fffbeb;
    color: #d97706;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
}

.icon-box-rose {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: #fef2f2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.2s ease;
}

.quick-action-item:hover {
    background: #ecfdf5;
    border-color: #10b981;
    transform: translateX(4px);
}
</style>

<!-- DASHBOARD HERO BANNER -->
<div class="dashboard-hero-banner">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <span class="badge bg-white bg-opacity-15 text-emerald-400 font-monospace text-uppercase mb-2 px-3 py-2" style="font-size:11px; letter-spacing:0.08em; border-radius:99px;">
                <i class="bi bi-building me-1"></i> {{ auth()->user()->clinica->nome ?? 'Clínica Principal' }}
            </span>
            <h3 class="fw-extrabold m-0 text-white" style="letter-spacing: -0.02em;">
                Olá, {{ auth()->user()->name ?? 'Administrador' }} 👋
            </h3>
            <p class="text-slate-300 fs-14 mt-1 mb-0">
                Resumo operacional e métricas de desempenho em {{ \Carbon\Carbon::now()->format('d \d\e F \d\e Y') }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('consultas.create') }}" class="btn btn-emerald fw-bold">
                <i class="bi bi-plus-circle-fill me-1"></i> Nova Consulta
            </a>
        </div>
    </div>
</div>

<!-- METRIC CARDS ROW 1 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card-glass">
            <div class="icon-box-emerald">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
            <div class="text-slate-500 fs-13 fw-semibold text-uppercase letter-spacing-1 mb-1">Consultas Hoje</div>
            <div class="fs-2 fw-extrabold text-slate-900 leading-none mb-2">{{ $consultas_hoje ?? 0 }}</div>
            <a href="{{ route('consultas.list') }}" class="text-emerald-600 fw-bold fs-13 text-decoration-none d-inline-flex align-items-center gap-1">
                Ver agenda do dia <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card-glass">
            <div class="icon-box-blue">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="text-slate-500 fs-13 fw-semibold text-uppercase letter-spacing-1 mb-1">Faturamento Mês</div>
            <div class="fs-3 fw-extrabold text-slate-900 leading-none mb-2">R$ {{ number_format($faturamento_mes ?? 0, 2, ',', '.') }}</div>
            <span class="text-blue-600 fw-bold fs-13 d-inline-flex align-items-center gap-1">
                <i class="bi bi-graph-up-arrow"></i> Meta de faturamento
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card-glass">
            <div class="icon-box-amber">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <div class="text-slate-500 fs-13 fw-semibold text-uppercase letter-spacing-1 mb-1">Novos Pacientes</div>
            <div class="fs-2 fw-extrabold text-slate-900 leading-none mb-2">{{ $novos_pacientes_mes ?? 0 }}</div>
            <a href="{{ route('admin.pacientes') }}" class="text-amber-600 fw-bold fs-13 text-decoration-none d-inline-flex align-items-center gap-1">
                Lista de pacientes <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card-glass">
            <div class="icon-box-rose">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
            <div class="text-slate-500 fs-13 fw-semibold text-uppercase letter-spacing-1 mb-1">Ticket Médio</div>
            <div class="fs-3 fw-extrabold text-slate-900 leading-none mb-2">R$ {{ number_format($ticket_medio ?? 0, 2, ',', '.') }}</div>
            <span class="text-rose-600 fw-bold fs-13">Por atendimento</span>
        </div>
    </div>
</div>

<!-- METRIC CARDS ROW 2 (EQUIPE & SAAS) -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box-emerald mb-0"><i class="bi bi-person-badge-fill"></i></div>
                <div>
                    <div class="fs-2 fw-extrabold text-slate-900">{{ $quantidade_medicos ?? 0 }}</div>
                    <div class="text-slate-500 fs-13 font-semibold">Médicos no Corpo Clínico</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box-blue mb-0"><i class="bi bi-person-workspace"></i></div>
                <div>
                    <div class="fs-2 fw-extrabold text-slate-900">{{ $quantidade_recepcionistas ?? 0 }}</div>
                    <div class="text-slate-500 fs-13 font-semibold">Recepcionistas Ativas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box-amber mb-0"><i class="bi bi-shield-check"></i></div>
                <div>
                    <div class="fs-2 fw-extrabold text-slate-900">{{ $quantidade_convenios ?? 0 }}</div>
                    <div class="text-slate-500 fs-13 font-semibold">Convênios Credenciados</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS & QUICK ACTIONS -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="fw-bold text-slate-900 m-0">Consultas Realizadas na Semana</h5>
                    <small class="text-muted">Distribuição diária dos atendimentos</small>
                </div>
                <span class="badge bg-emerald-50 text-emerald-700 fw-bold px-3 py-2" style="border-radius:99px;">Esta Semana</span>
            </div>
            <div style="height: 260px;">
                <canvas id="consultasChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold text-slate-900 mb-3">Atalhos Rápido</h5>

            <div class="d-flex flex-column gap-3">
                <a href="{{ route('consultas.create') }}" class="quick-action-item">
                    <div class="bg-emerald-500 text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="bi bi-calendar-plus-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-slate-900 fs-14">Agendar Consulta</div>
                        <small class="text-muted">Registrar novo paciente/horário</small>
                    </div>
                </a>

                <a href="{{ route('admin.medicos.create') }}" class="quick-action-item">
                    <div class="bg-blue-600 text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-slate-900 fs-14">Cadastrar Médico</div>
                        <small class="text-muted">Adicionar especialista</small>
                    </div>
                </a>

                <a href="{{ route('admin.convenios.create') }}" class="quick-action-item">
                    <div class="bg-amber-500 text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="bi bi-shield-plus"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-slate-900 fs-14">Novo Convênio</div>
                        <small class="text-muted">Configurar tabela de desconto</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('consultasChart').getContext('2d');
    
    let gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Consultas',
                data: [{{ $consultas_semana[1] ?? 0 }}, {{ $consultas_semana[2] ?? 0 }}, {{ $consultas_semana[3] ?? 0 }}, {{ $consultas_semana[4] ?? 0 }}, {{ $consultas_semana[5] ?? 0 }}, {{ $consultas_semana[6] ?? 0 }}, {{ $consultas_semana[7] ?? 0 }}],
                backgroundColor: gradient,
                borderColor: '#10b981',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#10b981',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 12 }, color: '#64748b' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 12 }, color: '#64748b' }
                }
            }
        }
    });
});
</script>

@endsection