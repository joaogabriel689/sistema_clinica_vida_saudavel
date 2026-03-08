@extends('layouts.base')

@section('content')
    <h1>Consultas</h1>

    <div>
        {{ $consultas_do_dia }}
    </div>
    <div>
        {{ $consultas_do_mes }}

    </div>
    <div>
        {{ $consultas_pendentes_confirmacao }}
    </div>
    <div>
        {{ $consultas_canceladas }}
    </div>


    <a href="{{ route('consultas.create') }}" class="btn btn-primary mb-3">Agendar Consulta</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Especialidade</th>
                <th>Data e Hora</th>
                <th>Convênio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->id }}</td>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->medico->nome }}</td>
                    <td>{{ $consulta->especialidade->nome }}</td>
                    <td>{{ $consulta->data_hora }}</td>
                    <td>{{ $consulta->convenio->nome }}</td>
                    <td>
                        <a href="{{ route('consultas.edit', $consulta->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta consulta?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $consultas->links() }}