@extends('layouts.base')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Consultas</h2>

        <a href="{{ route('consultas.create') }}" class="btn btn-primary">
            Agendar Consulta
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card">

        <div class="card-body">

            <table class="table table-hover table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Especialidade</th>
                        <th>Data / Hora</th>
                        <th>Convênio</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($consultas as $consulta)

                        <tr>

                            <td>{{ $consulta->id }}</td>

                            <td>
                                {{ $consulta->paciente->nome ?? '—' }}
                            </td>

                            <td>
                                {{ $consulta->medico->nome ?? '—' }}
                            </td>

                            <td>
                                {{ $consulta->especialidade->nome ?? '—' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                {{ $consulta->convenio->nome ?? 'Particular' }}
                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route('consultas.edit', $consulta->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form action="{{ route('consultas.destroy', $consulta->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta consulta?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Excluir
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Nenhuma consulta cadastrada.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection