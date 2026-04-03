@extends('layouts.base')
@section('title', 'Todas as Consultas')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Todas as Consultas</h2>
        <p>Listagem completa com filtros avançados</p>
    </div>
    <a href="{{ route('consultas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nova Consulta
    </a>
</div>

{{-- FILTERS --}}
<div class="card mb-4 fade-in fade-in-1">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('consultas.list') }}">
            <div class="row g-2 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Paciente ou médico"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Data</label>
                    <input type="date" name="data" class="form-control" value="{{ request('data') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Médico</label>
                    <select name="medico" class="form-select">
                        <option value="">Todos</option>
                        @foreach($medicos as $medico)
                            <option value="{{ $medico->id }}"
                                {{ request('medico') == $medico->id ? 'selected' : '' }}>
                                {{ $medico->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Especialidade</label>
                    <select name="especialidade" class="form-select">
                        <option value="">Todas</option>
                        @foreach($especialidades as $especialidade)
                            <option value="{{ $especialidade->id }}"
                                {{ request('especialidade') == $especialidade->id ? 'selected' : '' }}>
                                {{ $especialidade->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Convênio</label>
                    <select name="convenio" class="form-select">
                        <option value="">Todos</option>
                        @foreach($convenios as $convenio)
                            <option value="{{ $convenio->id }}"
                                {{ request('convenio') == $convenio->id ? 'selected' : '' }}>
                                {{ $convenio->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-flex gap-1">
                    <button class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i></button>
                    <a href="{{ route('consultas.list') }}" class="btn btn-secondary"><i class="bi bi-x"></i></a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card fade-in fade-in-2">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Médico / Especialidade</th>
                        <th>Data</th>
                        <th>Convênio</th>
                        <th>Status</th>
                        <th>Pagamento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($consultas as $consulta)

                @php
                    $statusColors = [
                        'agendada' => 'secondary',
                        'confirmada' => 'info',
                        'realizada' => 'primary',
                        'cancelada' => 'danger',
                    ];
                @endphp

                <tr>
                    <td>#{{ $consulta->id }}</td>

                    <td>{{ $consulta->paciente->nome ?? '—' }}</td>

                    <td>
                        <div>{{ $consulta->medico->nome ?? '—' }}</div>
                        <small class="text-muted">
                            {{ $consulta->medico->especialidade->nome ?? '—' }}
                        </small>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                    </td>

                    <td>{{ $consulta->convenio->nome ?? 'Particular' }}</td>

                    {{-- STATUS --}}
                    <td>

                        {{-- BADGE --}}
                        <span class="badge bg-{{ $statusColors[$consulta->status] ?? 'secondary' }}">
                            {{ ucfirst($consulta->status) }}
                        </span>

                        {{-- SELECT --}}
                        @if($consulta->status !== 'cancelada')
                        <form action="{{ route('consultas.alterar_status', $consulta->id) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="tipo" value="status">

                            <select name="status"
                                    class="form-select form-select-sm"
                                    onchange="this.form.submit()">

                                <option value="agendada"   {{ $consulta->status == 'agendada' ? 'selected' : '' }}>Agendada</option>
                                <option value="confirmada" {{ $consulta->status == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="realizada"  {{ $consulta->status == 'realizada' ? 'selected' : '' }}>Realizada</option>
                                <option value="cancelada"  {{ $consulta->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>

                            </select>
                        </form>
                        @endif

                    </td>

                    {{-- PAGAMENTO --}}
                    <td>

                        @if($consulta->status === 'cancelada')
                            <span class="badge bg-secondary">Indisponível</span>

                        @elseif($consulta->pago == 1)
                            <span class="badge bg-success">
                                <i class="bi bi-check2 me-1"></i>Pago
                            </span>

                        @else
                            <form action="{{ route('consultas.confirmar_pagamento', $consulta->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="tipo" value="pagamento">
                                <input type="hidden" name="pago" value="1">

                                <button class="btn btn-sm btn-outline-success">
                                    Confirmar
                                </button>
                            </form>
                        @endif

                    </td>

                    {{-- AÇÕES --}}
                    <td class="text-end">
                        <a href="{{ route('consultas.edit', $consulta->id) }}"
                           class="btn btn-sm btn-outline-primary">
                           <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('consultas.destroy', $consulta->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Excluir esta consulta?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        Nenhuma consulta encontrada.
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    @if($consultas->hasPages())
    <div class="card-footer">
        {{ $consultas->withQueryString()->links() }}
    </div>
    @endif

</div>

@endsection