@extends('layouts.base')

@section('title', 'Editar Convênio')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Editar Convênio</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.convenios.update', $convenio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Convênio</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        required
                        value="{{ $convenio->nome }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input
                        type="text"
                        class="form-control"
                        id="codigo"
                        name="codigo"
                        required
                        value="{{ $convenio->codigo }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="percentual_desconto" class="form-label">
                        Percentual de Desconto
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        id="percentual_desconto"
                        name="percentual_desconto"
                        min="0"
                        max="100"
                        required
                        value="{{ $convenio->percentual_desconto }}"
                    >
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Atualizar Convênio
                    </button>

                    <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection