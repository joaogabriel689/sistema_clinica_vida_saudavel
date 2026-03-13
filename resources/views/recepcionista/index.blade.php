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

    {{-- mensagem --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- busca --}}
    <div class="card mb-3">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.recepcionistas') }}">

                <div class="row g-2">

                    <div class="col-md-10">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Buscar por nome ou email..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary w-100">
                            Buscar
                        </button>

                        <a href="{{ route('admin.recepcionistas') }}" class="btn btn-secondary">
                            Limpar
                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- contador --}}
    <div class="mb-2 text-muted">
        Total: {{ $recepcionistas->total() }} recepcionistas
    </div>


    <div class="card shadow-sm">
        <div class="card-body">

            @if($recepcionistas->isEmpty())

                <div class="alert alert-info mb-0">
                    Nenhum recepcionista encontrado.
                </div>

            @else

            <div class="table-responsive">

                <table class="table table-striped align-middle">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th class="text-end" style="width:150px">Ações</th>
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

                                    <button
                                        type="submit"
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


    {{-- paginação --}}
    <div class="mt-3">
        {{ $recepcionistas->withQueryString()->links() }}
    </div>

</div>

@endsection