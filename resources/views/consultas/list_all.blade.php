@extends('layouts.base')

@section('title', 'Gestão de Consultas')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Gestão de Consultas</h3>
        <p class="text-muted fs-14 m-0">Agendamentos, confirmações por WhatsApp e controle de pagamentos</p>
    </div>
    <a href="{{ route('consultas.create') }}" class="btn btn-emerald">
        <i class="bi bi-plus-circle-fill me-1"></i> Nova Consulta
    </a>
</div>

<!-- FILTER CARD -->
<div class="card-custom p-4 mb-4">
    <form method="GET" action="{{ route('consultas.list') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Buscar Paciente ou Médico</label>
                <input type="text" name="search" class="form-control form-control-custom"
                       placeholder="Digite um nome..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-lg-2 col-md-6">
                <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Data</label>
                <input type="date" name="data" class="form-control form-control-custom" value="{{ request('data') }}">
            </div>

            <div class="col-lg-2 col-md-4">
                <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Médico</label>
                <select name="medico" class="form-select form-control-custom">
                    <option value="">Todos os Médicos</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ request('medico') == $medico->id ? 'selected' : '' }}>
                            {{ $medico->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Especialidade</label>
                <select name="especialidade" class="form-select form-control-custom">
                    <option value="">Todas</option>
                    @foreach($especialidades as $especialidade)
                        <option value="{{ $especialidade->id }}" {{ request('especialidade') == $especialidade->id ? 'selected' : '' }}>
                            {{ $especialidade->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Convênio</label>
                <select name="convenio" class="form-select form-control-custom">
                    <option value="">Todos os Convênios</option>
                    @foreach($convenios as $convenio)
                        <option value="{{ $convenio->id }}" {{ request('convenio') == $convenio->id ? 'selected' : '' }}>
                            {{ $convenio->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-1 d-flex gap-2">
                <button type="submit" class="btn btn-emerald w-100 p-2" title="Filtrar"><i class="bi bi-funnel-fill"></i></button>
                <a href="{{ route('consultas.list') }}" class="btn btn-outline-secondary p-2" title="Limpar"><i class="bi bi-x-lg"></i></a>
            </div>
        </div>
    </form>
</div>

<!-- CONSULTATIONS TABLE -->
<div class="card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-slate-50 border-bottom">
                <tr>
                    <th class="ps-4">Código</th>
                    <th>Paciente</th>
                    <th>Médico & Especialidade</th>
                    <th>Data & Horário</th>
                    <th>Convênio</th>
                    <th>Status Consulta</th>
                    <th>Pagamento</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultas as $consulta)
                <tr>
                    <td class="ps-4 fw-bold text-slate-500">#{{ $consulta->id }}</td>

                    <td>
                        <div class="fw-bold text-slate-900 fs-14">{{ $consulta->paciente->nome ?? '—' }}</div>
                        <small class="text-muted"><i class="bi bi-telephone me-1"></i> {{ $consulta->paciente->telefone ?? '—' }}</small>
                    </td>

                    <td>
                        <div class="fw-bold text-slate-900 fs-14">{{ $consulta->medico->nome ?? '—' }}</div>
                        <span class="badge bg-emerald-50 text-emerald-700 fs-11 font-semibold">{{ $consulta->medico->especialidade->nome ?? 'Geral' }}</span>
                    </td>

                    <td>
                        <div class="fw-bold text-slate-900 fs-14">
                            {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y') }}
                        </div>
                        <small class="text-emerald-600 fw-bold">
                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('H:i') }}
                        </small>
                    </td>

                    <td>
                        <span class="badge bg-slate-100 text-slate-700 fs-12 border">
                            {{ $consulta->convenio->nome ?? 'Particular' }}
                        </span>
                    </td>

                    <td>
                        @php
                            $badgeMap = [
                                'agendada' => 'bg-secondary text-white',
                                'confirmada' => 'bg-info text-dark',
                                'realizada' => 'bg-emerald-500 text-white',
                                'cancelada' => 'bg-danger text-white',
                            ];
                        @endphp

                        <span class="badge {{ $badgeMap[$consulta->status] ?? 'bg-secondary' }} px-3 py-2 fs-12 mb-1">
                            {{ ucfirst($consulta->status) }}
                        </span>

                        @if($consulta->status !== 'cancelada')
                        <form action="{{ route('consultas.alterar_status', $consulta->id) }}" method="POST" class="d-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="tipo" value="status">
                            <select name="status" class="form-select form-select-sm border-slate-200 mt-1" style="font-size:11px;" onchange="this.form.submit()">
                                <option value="agendada" {{ $consulta->status == 'agendada' ? 'selected' : '' }}>Agendada</option>
                                <option value="confirmada" {{ $consulta->status == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="realizada" {{ $consulta->status == 'realizada' ? 'selected' : '' }}>Realizada</option>
                                <option value="cancelada" {{ $consulta->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </form>
                        @endif
                    </td>

                    <td>
                        @if($consulta->pago == 1)
                            <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-2 fs-12">
                                <i class="bi bi-check-circle-fill me-1"></i> Pago (R$ {{ number_format($consulta->valor, 2, ',', '.') }})
                            </span>
                        @else
                            <form action="{{ route('consultas.confirmar_pagamento', $consulta->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipo" value="pagamento">
                                <input type="hidden" name="pago" value="1">
                                <button type="submit" class="btn btn-sm btn-outline-emerald font-semibold py-1">
                                    <i class="bi bi-cash me-1"></i> Confirmar (R$ {{ number_format($consulta->valor, 2, ',', '.') }})
                                </button>
                            </form>
                        @endif
                    </td>

                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('consultas.edit', $consulta->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" onsubmit="return confirm('Excluir esta consulta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-1 text-slate-300 d-block mb-2"></i>
                        Nenhuma consulta encontrada para os filtros selecionados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($consultas->hasPages())
    <div class="p-3 border-top bg-slate-50">
        {{ $consultas->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection