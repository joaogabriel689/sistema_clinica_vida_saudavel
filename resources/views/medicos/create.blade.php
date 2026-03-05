@extends('layouts.base')

@section('title', 'Cadastrar Médico')

@section('content')

<div class="container d-flex justify-content-center align-items-center py-4">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 600px;">

        <h3 class="mb-4 text-center">Cadastrar Médico</h3>

        <form action="{{ route('admin.medicos.store') }}" method="POST">
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- CRM --}}
            <div class="mb-3">
                <label class="form-label">CRM</label>
                <input 
                    type="text" 
                    name="crm" 
                    class="form-control @error('crm') is-invalid @enderror"
                    value="{{ old('crm') }}"
                    required
                >

                @error('crm')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Especialidade --}}
            <div class="mb-3">
                <label class="form-label">Especialidade</label>

                <select 
                    name="especialidade"
                    class="form-select @error('especialidade') is-invalid @enderror"
                    required
                >
                    <option value="">Selecione uma especialidade</option>

                    {{-- Lista de especialidades --}}
                    @foreach($especialidades as $especialidade)
                        <option 
                            value="{{ $especialidade->id }}"
                            {{ old('especialidade') == $especialidade->id ? 'selected' : '' }}
                        >
                            {{ $especialidade->nome }}
                        </option>
                    @endforeach

                    {{-- Opção para criar nova --}}
                    <option value="outra" {{ old('especialidade') == 'outra' ? 'selected' : '' }}>
                        Outra especialidade
                    </option>
                </select>

                @error('especialidade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo para nova especialidade --}}
            <div class="mb-3 d-none" id="novaEspecialidadeContainer">
                <label class="form-label">Digite a nova especialidade</label>

                <input 
                    type="text" 
                    name="nova_especialidade"
                    class="form-control @error('nova_especialidade') is-invalid @enderror"
                    value="{{ old('nova_especialidade') }}"
                >

                @error('nova_especialidade')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="mb-3">
                <label class="form-label">Senha</label>

                <input 
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Horário de atendimento --}}
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Início</label>

                    <input 
                        type="time"
                        name="hora_inicio"
                        class="form-control @error('hora_inicio') is-invalid @enderror"
                        value="{{ old('hora_inicio') }}"
                        required
                    >

                    @error('hora_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Fim</label>

                    <input 
                        type="time"
                        name="hora_fim"
                        class="form-control @error('hora_fim') is-invalid @enderror"
                        value="{{ old('hora_fim') }}"
                        required
                    >

                    @error('hora_fim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Botão --}}
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">
                    Cadastrar
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Script para mostrar campo de nova especialidade --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const select = document.querySelector('select[name="especialidade"]');

    const container = document.getElementById('novaEspecialidadeContainer');

    function toggleNovaEspecialidade() {

        if (select.value === 'outra') {
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    }

    select.addEventListener('change', toggleNovaEspecialidade);

    toggleNovaEspecialidade();

});

</script>

@endsection