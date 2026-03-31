@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')

<style>
.insight-card {
    --accent: #16a34a;
    position: relative;
}
.insight-card.accent-blue  { --accent: #3b82f6; }
.insight-card.accent-amber { --accent: #f59e0b; }
.insight-card.accent-rose  { --accent: #ef4444; }

.welcome-banner {
    background: linear-gradient(135deg, #0f1f14 0%, #166534 60%, #16a34a 100%);
    border-radius: 16px;
    padding: 28px 32px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}

.welcome-banner::after {
    content: '\f473';
    font-family: 'Bootstrap Icons';
    position: absolute;
    right: 32px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 96px;
    opacity: .07;
    color: #fff;
    line-height: 1;
}

.welcome-banner h4 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 4px;
}

.welcome-banner p {
    font-size: 13.5px;
    opacity: .7;
    margin: 0;
}

.quick-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 16px;
    transition: background .18s;
}
.quick-action:hover { background: rgba(255,255,255,.25); color: #fff; }

.chart-wrapper {
    position: relative;
    height: 220px;
}

.section-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
}
</style>


{{-- WELCOME BANNER --}}
<div class="welcome-banner fade-in">
    <h4>Bom dia, {{ auth()->user()->name ?? 'Administrador' }} 👋</h4>
    <p>Aqui está o resumo de hoje — {{ \Carbon\Carbon::now()->format('d \d\e F \d\e Y') }}</p>
    @if($clinica == null)
        <a href="{{ route('admin.criar_clinica') }}" class="quick-action">
            <i class="bi bi-plus-circle"></i> Cadastrar clínica
        </a>
    @else
        <a href="{{ route('consultas.create') }}" class="quick-action">
            <i class="bi bi-calendar2-plus"></i> Agendar consulta
        </a>
    @endif
</div>


{{-- METRIC CARDS ROW --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3 fade-in fade-in-1">
        <div class="metric-card insight-card">
            <div class="metric-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-calendar2-check"></i>
            </div>
            <div class="metric-value">{{ $consultas_hoje ?? 0 }}</div>
            <div class="metric-label">Consultas Hoje</div>
            <a href="{{ route('consultas.list') }}" class="metric-link">
                Ver agenda <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-in fade-in-2">
        <div class="metric-card insight-card accent-blue">
            <div class="metric-icon" style="background:#eff6ff; color:#3b82f6;">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="metric-value" style="font-size:20px;">R$ {{ number_format($faturamento_mes ?? 0, 0, ',', '.') }}</div>
            <div class="metric-label">Faturamento do Mês</div>
            <a href="#" class="metric-link" style="color:#3b82f6;">
                Ver relatório <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-in fade-in-3">
        <div class="metric-card insight-card accent-amber">
            <div class="metric-icon" style="background:#fffbeb; color:#f59e0b;">
                <i class="bi bi-person-plus"></i>
            </div>
            <div class="metric-value">{{ $novos_pacientes_mes ?? 0 }}</div>
            <div class="metric-label">Novos Pacientes (mês)</div>
            <a href="#" class="metric-link" style="color:#f59e0b;">
                Ver pacientes <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-in fade-in-4">
        <div class="metric-card insight-card accent-rose">
            <div class="metric-icon" style="background:#fef2f2; color:#ef4444;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="metric-value" style="font-size:20px;">R$ {{ number_format($ticket_medio ?? 0, 0, ',', '.') }}</div>
            <div class="metric-label">Ticket Médio</div>
            <a href="#" class="metric-link" style="color:#ef4444;">
                Analisar <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

</div>


{{-- SECOND ROW --}}
<div class="row g-3 mb-4">

    <div class="col-md-4 col-6 fade-in fade-in-2">
        <div class="metric-card">
            <div class="metric-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="metric-value">{{ $quantidade_medicos }}</div>
            <div class="metric-label">Médicos Ativos</div>
            <a href="{{ route('admin.medicos') }}" class="metric-link">
                Gerenciar <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4 col-6 fade-in fade-in-3">
        <div class="metric-card">
            <div class="metric-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="metric-value">{{ $quantidade_recepcionistas }}</div>
            <div class="metric-label">Recepcionistas</div>
            <a href="{{ route('admin.recepcionistas') }}" class="metric-link">
                Gerenciar <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4 col-6 fade-in fade-in-4">
        <div class="metric-card">
            <div class="metric-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="metric-value">{{ $quantidade_convenios }}</div>
            <div class="metric-label">Convênios</div>
            <a href="{{ route('admin.convenios.index') }}" class="metric-link">
                Gerenciar <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

</div>


{{-- BOTTOM SECTION --}}
<div class="row g-3 fade-in fade-in-5">

    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart me-2 text-success"></i>Consultas por Semana</span>
                <span class="badge" style="background:#f0fdf4; color:#16a34a;">Este mês</span>
            </div>
            <div class="card-body p-4">
                <div class="chart-wrapper">
                    <canvas id="consultasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-lightning-charge me-2 text-warning"></i>Ações Rápidas
            </div>
            <div class="card-body p-3">

                <a href="{{ route('consultas.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none mb-2"
                   style="background:#f0fdf4; transition:.18s ease;"
                   onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
                    <div style="width:36px;height:36px;background:#16a34a;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;">
                        <i class="bi bi-calendar2-plus"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#111827;">Nova Consulta</div>
                        <div style="font-size:11.5px;color:#6b7280;">Agendar atendimento</div>
                    </div>
                </a>

                <a href="{{ route('admin.medicos.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none mb-2"
                   style="background:#f8fafc; transition:.18s ease;"
                   onmouseover="this.style.background='#f0f9ff'" onmouseout="this.style.background='#f8fafc'">
                    <div style="width:36px;height:36px;background:#3b82f6;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#111827;">Cadastrar Médico</div>
                        <div style="font-size:11.5px;color:#6b7280;">Adicionar ao quadro</div>
                    </div>
                </a>

                <a href="{{ route('admin.convenios.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#f8fafc; transition:.18s ease;"
                   onmouseover="this.style.background='#fefce8'" onmouseout="this.style.background='#f8fafc'">
                    <div style="width:36px;height:36px;background:#f59e0b;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;">
                        <i class="bi bi-shield-plus"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#111827;">Novo Convênio</div>
                        <div style="font-size:11.5px;color:#6b7280;">Cadastrar plano</div>
                    </div>
                </a>

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('consultasChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        datasets: [{
            label: 'Consultas',
            data: [8, 12, 9, 15, 11, 6, 3],
            backgroundColor: 'rgba(22,163,74,.15)',
            borderColor: '#16a34a',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f0f3f7' },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#9ca3af' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#9ca3af' }
            }
        }
    }
});
</script>

@endsection