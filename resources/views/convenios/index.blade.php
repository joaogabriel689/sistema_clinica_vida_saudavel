@extends('layouts.base')

@section('title', 'Convênios')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Convênios</h2>

        <a href="{{ route('admin.convenios.create') }}" class="btn btn-primary">
            Novo Convênio
        </a>
    </div>

    {{-- Mensagens --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Barra de busca --}}
    <div class="card mb-3">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.convenios.index') }}">

                <div class="row g-2">

                    <div class="col-md-10">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Buscar convênio..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary w-100">
                            Buscar
                        </button>

                        <a href="{{ route('admin.convenios.index') }}"
                           class="btn btn-secondary">
                           Limpar
                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Contador --}}
    <div class="mb-2 text-muted">
        Total: {{ $convenios->total() }} convênios
    </div>

    @if($convenios->isEmpty())

        <div class="alert alert-info">
            Nenhum convênio encontrado.
        </div>

    @else

        <div class="table-responsive">

            <table class="table table-striped align-middle">

                <thead>
                    <tr>
                        <th>Nome do Convênio</th>
                        <th class="text-end" style="width:180px">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($convenios as $convenio)

                    <tr>

                        <td>{{ $convenio->nome }}</td>

                        <td class="text-end">

                            <a href="{{ route('admin.convenios.edit', $convenio->id) }}"
                               class="btn btn-sm btn-outline-primary">
                               Editar
                            </a>

                            <form action="{{ route('admin.convenios.destroy', $convenio->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este convênio?')">

                                    Excluir

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- Paginação --}}
        <div class="mt-3">
            {{ $convenios->withQueryString()->links() }}
        </div>

    @endif

</div>
@endsection