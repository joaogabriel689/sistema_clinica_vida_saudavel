@extends('layouts.base')

@section('title', 'Convenios')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Convênios</h2>

        <a href="{{ route('admin.convenios.create') }}" class="btn btn-primary">
            Novo Convênio
        </a>
    </div>

    @if($convenios->isEmpty())

        <div class="alert alert-info">
            Nenhum convênio cadastrado.
        </div>

        <a href="{{ route('admin.convenios.create') }}" class="btn btn-primary">
            Criar Convênio
        </a>

    @else

        <table class="table table-striped align-middle">

            <thead>
                <tr>
                    <th>Nome do Convênio</th>
                    <th style="width:150px">Ações</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($convenios as $convenio)

                <tr>
                    <td>{{ $convenio->nome }}</td>

                    <td>

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

    @endif

</div>
@endsection