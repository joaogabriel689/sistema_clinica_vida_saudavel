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
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:9px 0 0 9px;border:1.5px solid #e5e7eb;border-right:none;background:#f9fafb;">
                            <i class="bi bi-search text-muted" style="font-size:12px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Paciente ou médico"
                               value="{{ request('search') }}"
                               style="border-left:none;border-radius:0 9px 9px 0;">
                    </div>
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
                        <th class="text-end" style="width:140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($consultas as $consulta)
                <tr>
                    <td><span class="text-muted" style="font-size:12px;">#{{ $consulta->id }}</span></td>

                    <td>
                        <div style="font-weight:600;font-size:13.5px;">{{ $consulta->paciente->nome ?? '—' }}</div>
                    </td>

                    <td>
                        <div style="font-size:13.5px;font-weight:500;">{{ $consulta->medico->nome ?? '—' }}</div>
                        <div style="font-size:11.5px;color:#9ca3af;">{{ $consulta->medico->especialidade->nome ?? '—' }}</div>
                    </td>

                    <td style="font-size:13px;white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                    </td>

                    <td style="font-size:13px;">{{ $consulta->convenio->nome ?? 'Particular' }}</td>

                    {{-- STATUS --}}
                    <td>
                        <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
                            @csrf @method('PUT')
                            <select name="status"
                                    class="form-select form-select-sm"
                                    onchange="this.form.submit()"
                                    style="min-width:120px;font-size:12px;">
                                <option value="agendada"   {{ $consulta->status == 'agendada'   ? 'selected' : '' }}>📅 Agendada</option>
                                <option value="confirmada" {{ $consulta->status == 'confirmada' ? 'selected' : '' }}>✅ Confirmada</option>
                                <option value="realizada"  {{ $consulta->status == 'realizada'  ? 'selected' : '' }}>🏁 Realizada</option>
                                <option value="cancelada"  {{ $consulta->status == 'cancelada'  ? 'selected' : '' }}>❌ Cancelada</option>
                            </select>
                        </form>
                    </td>

                    {{-- PAGAMENTO --}}
                    <td>
                        @if($consulta->pago)
                            <span class="badge bg-success"><i class="bi bi-check2 me-1"></i>Pago</span>
                        @else
                            <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="pago" value="1">
                                <button class="btn btn-sm btn-outline-success" style="font-size:12px;">
                                    <i class="bi bi-cash me-1"></i>Confirmar
                                </button>
                            </form>
                        @endif
                    </td>

                    {{-- AÇÕES --}}
                    <td class="text-end">
                        <a href="{{ route('consultas.edit', $consulta->id) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                           <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir esta consulta?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:8px;"></i>
                        <span class="text-muted">Nenhuma consulta encontrada.</span>
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    @if($consultas->hasPages())
    <div class="card-footer bg-transparent border-top px-4 py-3" style="border-color:#f0f3f7!important;">
        {{ $consultas->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection