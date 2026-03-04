@extends('layouts.base')

@section('title', 'Pacientes')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Pacientes</h2>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            Novo Paciente
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($pacientes->isEmpty())
                <p class="text-muted mb-0">Nenhum paciente cadastrado.</p>
            @else

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Data Nascimento</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->nome }}</td>
                            <td>{{ $paciente->cpf }}</td>
                            <td>{{ $paciente->telefone }}</td>
                            <td>{{ $paciente->data_nascimento }}</td>
                            <td class="text-end">

                                <a href="{{ route('pacientes.edit', $paciente->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('pacientes.destroy', $paciente->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este paciente?')">
                                        Excluir
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            @endif

        </div>
    </div>

</div>

@endsection