@extends('layouts.base')

@section('title', 'Cadastrar Convênio')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Cadastrar Convênio</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.convenios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Convênio</label>

                    <input
                        type="text"
                        class="form-control @error('nome') is-invalid @enderror"
                        id="nome"
                        name="nome"
                        value="{{ old('nome') }}"
                        required
                    >

                    @error('nome')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="codigo" class="form-label">Código do Convênio</label>

                    <input
                        type="text"
                        class="form-control @error('codigo') is-invalid @enderror"
                        id="codigo"
                        name="codigo"
                        value="{{ old('codigo') }}"
                        required
                    >

                    @error('codigo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="percentual_desconto" class="form-label">
                        Percentual de Desconto (%)
                    </label>

                    <input
                        type="number"
                        class="form-control @error('percentual_desconto') is-invalid @enderror"
                        id="percentual_desconto"
                        name="percentual_desconto"
                        min="0"
                        max="100"
                        step="0.01"
                        value="{{ old('percentual_desconto') }}"
                        required
                    >

                    @error('percentual_desconto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Cadastrar Convênio
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