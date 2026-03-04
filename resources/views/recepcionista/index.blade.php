@extends('layouts.base')

@section('title', 'Recepcionistas')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h2>Olá, {{ auth()->user()->name }} 👋</h2>
        <p class="text-muted">Bem-vindo ao painel administrativo</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lista de Recepcionistas</h4>
        <a href="{{ route('admin.recepcionistas.create') }}" class="btn btn-primary btn-sm">
            Novo Recepcionista
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($recepcionistas->isEmpty())
                <p class="text-muted mb-0">Nenhum recepcionista cadastrado.</p>
            @else

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recepcionistas as $recepcionista)
                        <tr>
                            <td>{{ $recepcionista->name }}</td>
                            <td>{{ $recepcionista->email }}</td>
                            <td class="text-end">



                                <form action="{{ route('admin.recepcionistas.destroy', $recepcionista->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este recepcionista?')">
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