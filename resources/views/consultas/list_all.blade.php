@extends('layouts.base')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Consultas</h2>

        <a href="{{ route('consultas.create') }}" class="btn btn-primary">
            Agendar Consulta
        </a>
    </div>

    {{-- FILTROS --}}
    <div class="card mb-3">

        <div class="card-body">

            <form method="GET" action="{{ route('consultas.list') }}">

                <div class="row g-2">

                    <div class="col-md-3">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Paciente ou médico"
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2">
                        <input
                            type="date"
                            name="data"
                            class="form-control"
                            value="{{ request('data') }}"
                        >
                    </div>

                    <div class="col-md-2">
                        <select name="medico" class="form-select">
                            <option value="">Médico</option>

                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}"
                                    {{ request('medico') == $medico->id ? 'selected' : '' }}>
                                    {{ $medico->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="especialidade" class="form-select">
                            <option value="">Especialidade</option>

                            @foreach($especialidades as $especialidade)
                                <option value="{{ $especialidade->id }}"
                                    {{ request('especialidade') == $especialidade->id ? 'selected' : '' }}>
                                    {{ $especialidade->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="convenio" class="form-select">
                            <option value="">Convênio</option>

                            @foreach($convenios as $convenio)
                                <option value="{{ $convenio->id }}"
                                    {{ request('convenio') == $convenio->id ? 'selected' : '' }}>
                                    {{ $convenio->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-1 d-flex gap-1">

                        <button class="btn btn-primary w-100">
                            🔍
                        </button>

                        <a href="{{ route('consultas.list') }}"
                           class="btn btn-secondary">
                           X
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- TABELA --}}
    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Especialidade</th>
                            <th>Data</th>
                            <th>Convênio</th>
                            <th>Status</th>
                            <th>Pagamento</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($consultas as $consulta)

                    <tr>

                        <td>{{ $consulta->id }}</td>

                        <td>{{ $consulta->paciente->nome ?? '—' }}</td>

                        <td>{{ $consulta->medico->nome ?? '—' }}</td>

                        <td>{{ $consulta->medico->especialidade->nome ?? '—' }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            {{ $consulta->convenio->nome ?? 'Particular' }}
                        </td>


                        {{-- STATUS --}}
                        <td>

                            <form action="{{ route('consultas.update', $consulta->id) }}"
                                  method="POST">

                                @csrf
                                @method('PUT')

                                <select name="status"
                                        class="form-select form-select-sm"
                                        onchange="this.form.submit()">

                                    <option value="agendada"
                                        {{ $consulta->status == 'agendada' ? 'selected' : '' }}>
                                        Agendada
                                    </option>

                                    <option value="confirmada"
                                        {{ $consulta->status == 'confirmada' ? 'selected' : '' }}>
                                        Confirmada
                                    </option>

                                    <option value="realizada"
                                        {{ $consulta->status == 'realizada' ? 'selected' : '' }}>
                                        Realizada
                                    </option>

                                    <option value="cancelada"
                                        {{ $consulta->status == 'cancelada' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>

                                </select>

                                <input type="submit" value="alterar" class="btn btn-sm btn-outline-secondary">

                            </form>

                        </td>


                        {{-- PAGAMENTO --}}
                        <td>

                            @if($consulta->pago)

                                <span class="badge bg-success">
                                    Pago
                                </span>

                            @else

                                <form action="{{ route('consultas.update', $consulta->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden"
                                           name="pago"
                                           value="1">

                                    <button class="btn btn-sm btn-success">
                                        Confirmar
                                    </button>

                                </form>

                            @endif

                        </td>


                        {{-- AÇÕES --}}
                        <td>

                            <div class="d-flex gap-1">

                                <a href="{{ route('consultas.edit', $consulta->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('consultas.destroy', $consulta->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Tem certeza?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        Excluir
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Nenhuma consulta encontrada.
                        </td>
                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <div class="mt-3">
        {{ $consultas->withQueryString()->links() }}
    </div>

</div>

@endsection