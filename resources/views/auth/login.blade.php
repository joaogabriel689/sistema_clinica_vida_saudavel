@extends('layouts.base')

@section('title', 'Login')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 450px;">

        <h3 class="text-center mb-4">Entrar</h3>

        <form action="{{ route('auth-login') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
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
                <label for="password" class="form-label">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
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
                    Entrar
                </button>
            </div>

        </form>

        <div class="text-center mt-3">
            <small>Não possui conta? <a href="{{ route('register') }}">Cadastrar</a></small>
        </div>

    </div>
</div>

@endsection