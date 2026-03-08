@extends('layouts.base')

@section('title', 'Médicos')

@section('content')

<div class="container py-4">

    <a href="{{ route('admin.medicos.create') }}" class="btn btn-primary mb-3">Cadastrar Médico</a>
    <h2 class="mb-4">Médicos Cadastrados</h2>
    @if($medicos->isEmpty())
        <p class="text-muted">Nenhum médico cadastrado ainda.</p>
    @else
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CRM</th>
                        <th>Especialidade</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicos as $medico)
                    <tr>
                        <td>{{ $medico->nome }}</td>
                        <td>{{ $medico->crm }}</td>
                        <td>{{ $medico->especialidade->nome ?? '—' }}</td>
                        <td>{{ $medico->telefone }}</td>
                        <td>{{ $medico->email }}</td>
                        <td>
                            <a href="{{ route('admin.medicos.edit', $medico->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('admin.medicos.destroy', $medico->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este médico?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

@endsection