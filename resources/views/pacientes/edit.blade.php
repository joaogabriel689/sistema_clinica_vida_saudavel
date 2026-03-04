@extends('layouts.base')

@section('title', 'Editar Paciente')

@section('content')

<div class="container d-flex justify-content-center align-items-center py-4">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 600px;">

        <h3 class="mb-4 text-center">Editar Paciente</h3>

        <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nome --}}
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input 
                    type="text" 
                    name="nome" 
                    class="form-control @error('nome') is-invalid @enderror"
                    value="{{ old('nome', $paciente->nome) }}"
                    required
                >
                @error('nome')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- CPF --}}
            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input 
                    type="text" 
                    name="cpf" 
                    class="form-control @error('cpf') is-invalid @enderror"
                    value="{{ old('cpf', $paciente->cpf) }}"
                    required
                >
                @error('cpf')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Telefone --}}
            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input 
                    type="text" 
                    name="telefone" 
                    class="form-control @error('telefone') is-invalid @enderror"
                    value="{{ old('telefone', $paciente->telefone) }}"
                >
                @error('telefone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Endereço --}}
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input 
                    type="text" 
                    name="endereco" 
                    class="form-control @error('endereco') is-invalid @enderror"
                    value="{{ old('endereco', $paciente->endereco) }}"
                >
                @error('endereco')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Data de Nascimento --}}
            <div class="mb-4">
                <label class="form-label">Data de Nascimento</label>
                <input 
                    type="date" 
                    name="data_nascimento" 
                    class="form-control @error('data_nascimento') is-invalid @enderror"
                    value="{{ old('data_nascimento', $paciente->data_nascimento) }}"
                >
                @error('data_nascimento')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Atualizar
                </button>
            </div>

        </form>

    </div>
</div>

@endsection