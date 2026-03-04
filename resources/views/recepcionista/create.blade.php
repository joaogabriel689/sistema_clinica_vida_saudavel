@extends('layouts.base')

@section('title', 'Cadastrar Recepcionista')

@section('content')

<div class="container d-flex justify-content-center align-items-center py-4">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">

        <h3 class="mb-4 text-center">Cadastrar Recepcionista</h3>

        <form action="{{ route('admin.recepcionistas.store') }}" method="POST">
            @csrf

            {{-- Nome --}}
            <div class="mb-3">
                <label class="form-label">Nome</label>
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

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Cadastrar
                </button>
            </div>

        </form>

    </div>
</div>

@endsection