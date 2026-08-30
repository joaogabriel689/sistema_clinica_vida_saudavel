@extends('layouts.base')

@section('title', 'Plano & Assinatura da Clínica')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Plano & Assinatura da Clínica</h3>
        <p class="text-muted fs-14 m-0">Gerencie sua assinatura, limites da equipe e pagamento via Gateway Asaas</p>
    </div>
    
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-slate-100 text-slate-700 border border-slate-300 px-3 py-2 fs-13">
            <i class="bi bi-credit-card-2-front text-slate-500 me-1"></i> Gateway Asaas v3
        </span>
        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-2 fs-13 fw-bold">
            <i class="bi bi-shield-check text-emerald-600 me-1"></i> Status: {{ strtoupper($assinatura->status ?? 'TRIAL') }}
        </span>
    </div>
</div>

<!-- CURRENT PLAN HERO -->
<div class="card-custom p-4 mb-4" style="background: linear-gradient(135deg, #061610 0%, #064e3b 100%); color:#fff;">
    <div class="row align-items-center g-4">
        <div class="col-md-8">
            <span class="badge bg-white bg-opacity-15 text-emerald-400 font-monospace text-uppercase mb-2 px-3 py-1" style="font-size:11px;">
                PLANO ATIVO NA CLÍNICA
            </span>
            <h2 class="fw-extrabold text-white m-0">{{ $assinatura->plano->nome ?? 'Clínica Pro' }}</h2>
            <p class="text-slate-300 fs-14 mt-1 mb-3">
                Próximo ciclo programado para {{ \Carbon\Carbon::parse($assinatura->proxima_cobranca)->format('d/m/Y') }}
            </p>

            <div class="d-flex gap-4 flex-wrap text-slate-300 fs-13">
                <div><i class="bi bi-check-circle-fill text-emerald-400 me-1"></i> Suporte Prioritário 24/7</div>
                <div><i class="bi bi-whatsapp text-emerald-400 me-1"></i> Lembretes WhatsApp Inclusos</div>
                <div><i class="bi bi-shield-lock-fill text-emerald-400 me-1"></i> Prontuário LGPD Protegido</div>
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <div class="fs-1 fw-extrabold text-white">R$ {{ number_format($assinatura->plano->preco_mensal ?? $assinatura->plano->preco ?? 299, 2, ',', '.') }}</div>
            <span class="text-slate-300 fs-13">/ mês</span>
        </div>
    </div>
</div>

<!-- USAGE LIMITS -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-slate-700 fs-14">Médicos Cadastrados</span>
                <span class="fw-extrabold text-emerald-600 fs-14">{{ $medicosCount }} / {{ $assinatura->plano->max_medicos ?? $assinatura->plano->limite_medicos ?? 5 }}</span>
            </div>
            <div class="progress" style="height: 10px; border-radius:99px;">
                <div class="progress-bar bg-emerald-500" role="progressbar" style="width: {{ min(100, ($medicosCount / max(1, $assinatura->plano->max_medicos ?? 5)) * 100) }}%;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-slate-700 fs-14">Consultas Realizadas este Mês</span>
                <span class="fw-extrabold text-blue-600 fs-14">{{ $consultasMesCount }} / Ilimitado</span>
            </div>
            <div class="progress" style="height: 10px; border-radius:99px;">
                <div class="progress-bar bg-blue-500" role="progressbar" style="width: 35%;"></div>
            </div>
        </div>
    </div>
</div>

<!-- CHANGE PLAN CARDS -->
<h4 class="fw-extrabold text-slate-900 mb-3">Upgrade ou Troca de Plano</h4>
<div class="row g-4 mb-5">
    @foreach($planos as $plano)
    <div class="col-lg-4">
        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between {{ ($assinatura->plano_id == $plano->id) ? 'border-emerald-500 border-2' : '' }}">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="fw-bold text-slate-900 m-0">{{ $plano->nome }}</h4>
                    @if($assinatura->plano_id == $plano->id)
                        <span class="badge bg-emerald-500 text-white fs-11">Plano Atual</span>
                    @endif
                </div>

                <div class="fs-2 fw-extrabold text-slate-900 mb-3">R$ {{ number_format($plano->preco_mensal ?? $plano->preco, 2, ',', '.') }} <small class="fs-13 text-muted">/mês</small></div>

                <ul class="list-unstyled mb-4 d-flex flex-column gap-2 text-slate-700 fs-14">
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Até {{ $plano->max_medicos ?? $plano->limite_medicos }} Médicos</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Até {{ $plano->max_recepcionistas ?? $plano->limite_recepcionistas }} Recepcionistas</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Lembretes WhatsApp Inclusos</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Página Pública da Clínica</li>
                </ul>
            </div>

            @if($assinatura->plano_id != $plano->id)
            <form action="{{ route('billing.mudar_plano') }}" method="POST">
                @csrf
                <input type="hidden" name="plano_id" value="{{ $plano->id }}">
                <div class="mb-2">
                    <select name="billing_type" class="form-select form-select-sm">
                        <option value="PIX">Pagamento via PIX (Instantâneo)</option>
                        <option value="BOLETO">Boleto Bancário</option>
                        <option value="CREDIT_CARD">Cartão de Crédito</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-emerald w-100 font-semibold py-2">
                    Migrar para {{ $plano->nome }} via Asaas
                </button>
            </form>
            @else
            <button class="btn btn-slate-100 text-slate-500 w-100 fw-bold py-2" disabled>Plano Em Uso</button>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- INVOICES HISTORY -->
<h4 class="fw-extrabold text-slate-900 mb-3">Histórico de Faturas</h4>
<div class="card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-slate-50 border-bottom">
                <tr>
                    <th class="ps-4">Fatura</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faturas as $fatura)
                <tr>
                    <td class="ps-4 fw-bold text-slate-700">#FAT-{{ $fatura->id }}</td>
                    <td class="fw-extrabold text-slate-900">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($fatura->data_vencimento)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $fatura->status === 'paga' ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : 'bg-amber-100 text-amber-800 border-amber-300' }} border px-3 py-1 fs-12">
                            {{ ucfirst($fatura->status) }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-download me-1"></i> Comprovante</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-receipt fs-2 text-slate-300 d-block mb-1"></i>
                        Nenhuma fatura pendente ou cobrança anterior registrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
