@extends('layouts.base')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Consultas</h2>

        <a href="{{ route('consultas.create') }}" class="btn btn-primary">
            Agendar Consulta
        </a>
    </div>

    {{-- MÉTRICAS --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Hoje</h6>
                    <h3>{{ $consultas_do_dia }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Este mês</h6>
                    <h3>{{ $consultas_do_mes }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Pendentes</h6>
                    <h3>{{ $consultas_pendentes_confirmacao }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Canceladas</h6>
                    <h3>{{ $consultas_canceladas }}</h3>
                </div>
            </div>
        </div>

    </div>


    {{-- BUSCA --}}
    <div class="card mb-3">
        <div class="card-body">

            <form method="GET" action="{{ route('consultas.index') }}">

                <div class="row g-2">

                    <div class="col-md-10">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Buscar por paciente ou médico..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary w-100">
                            Buscar
                        </button>

                        <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                            Limpar
                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- TABELA --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Especialidade</th>
                            <th>Data e Hora</th>
                            <th>Convênio</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($consultas as $consulta)

                        <tr>

                            <td>{{ $consulta->id }}</td>

                            <td>{{ $consulta->paciente->nome }}</td>

                            <td>{{ $consulta->medico->nome }}</td>

                            <td>{{ $consulta->especialidade->nome }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($consulta->data_hora)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                {{ $consulta->convenio->nome ?? 'Particular' }}
                            </td>

                            <td class="text-end">

                                <a href="{{ route('consultas.edit', $consulta->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                   Editar
                                </a>

                                <form action="{{ route('consultas.destroy', $consulta->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir esta consulta?')">

                                        Excluir

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Nenhuma consulta encontrada
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- PAGINAÇÃO --}}
    <div class="mt-3">
        {{ $consultas->withQueryString()->links() }}
    </div>

</div>

@endsection