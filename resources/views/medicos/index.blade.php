@extends('layouts.base')

@section('title', 'Médicos')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Médicos Cadastrados</h2>

        <a href="{{ route('admin.medicos.create') }}" class="btn btn-primary">
            Cadastrar Médico
        </a>
    </div>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- Barra de busca --}}
    <div class="card mb-3">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.medicos') }}">

                <div class="row g-2">

                    <div class="col-md-10">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Buscar por nome, CRM ou email..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2 d-flex gap-2">

                        <button class="btn btn-primary w-100">
                            Buscar
                        </button>

                        <a href="{{ route('admin.medicos') }}" class="btn btn-secondary">
                            Limpar
                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- Contador --}}
    <div class="mb-2 text-muted">
        Total: {{ $medicos->total() }} médicos
    </div>


    @if($medicos->isEmpty())

        <div class="alert alert-info">
            Nenhum médico encontrado.
        </div>

    @else

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CRM</th>
                            <th>Especialidade</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th class="text-end" style="width:180px">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($medicos as $medico)

                        <tr>

                            <td>{{ $medico->nome }}</td>

                            <td>{{ $medico->crm }}</td>

                            <td>
                                {{ $medico->especialidade->nome ?? '—' }}
                            </td>

                            <td>{{ $medico->telefone }}</td>

                            <td>{{ $medico->user->email }}</td>

                            <td class="text-end">

                                <a href="{{ route('admin.medicos.edit', $medico->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                   Editar
                                </a>

                                <form action="{{ route('admin.medicos.destroy', $medico->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir este médico?')">

                                        Excluir

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Paginação --}}
    <div class="mt-3">
        {{ $medicos->withQueryString()->links() }}
    </div>

    @endif

</div>

@endsection