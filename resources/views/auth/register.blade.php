@extends('layouts.base')

@section('title', 'Cadastro')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">

        <h3 class="text-center mb-4">Criar Conta</h3>

        <form method="POST" action="{{ route('auth-register') }}">
            @csrf

            {{-- Nome --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="email" 
                    name="email"
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
                <label for="password" class="form-label">Senha</label>
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    id="password" 
                    name="password"
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

        <div class="text-center mt-3">
            <small>Já possui conta? <a href="{{ route('login') }}">Entrar</a></small>
        </div>

    </div>
</div>

@endsection