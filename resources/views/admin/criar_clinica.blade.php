@extends('layouts.base')

@section('title', 'Criar Clínica')

@section('content')

<div class="container d-flex justify-content-center align-items-center py-4">
    
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 600px;">
        
        <h3 class="mb-4 text-center">Cadastrar Clínica</h3>

        <form action="{{ route('admin.store_clinica') }}" method="POST">
            @csrf

            {{-- Nome --}}
            <div class="mb-3">
                <label class="form-label">Nome da Clínica</label>
                <input 
                    type="text" 
                    name="nome" 
                    class="form-control @error('nome') is-invalid @enderror"
                    value="{{ old('nome') }}"
                    required
                >

                @error('nome')
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
                    value="{{ old('endereco') }}"
                    required
                >

                @error('endereco')
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
                    value="{{ old('telefone') }}"
                    required
                >

                @error('telefone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- CNPJ --}}
            <div class="mb-3">
                <label class="form-label">CNPJ</label>
                <input 
                    type="text" 
                    name="cnpj" 
                    class="form-control @error('cnpj') is-invalid @enderror"
                    value="{{ old('cnpj') }}"
                    required
                >

                @error('cnpj')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Botão --}}
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">
                    Criar Clínica
                </button>
            </div>

        </form>

    </div>

</div>

@endsection