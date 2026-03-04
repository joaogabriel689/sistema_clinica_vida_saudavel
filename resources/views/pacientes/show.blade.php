@extends('layouts.base')

@section('title', 'Dados do Paciente')

@section('content')

<div class="container py-4 d-flex justify-content-center">
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">

        <div class="card-body">

            <h3 class="mb-4 text-center">Dados do Paciente</h3>

            <p><strong>Nome:</strong> {{ $paciente->nome }}</p>
            <p><strong>CPF:</strong> {{ $paciente->cpf }}</p>
            <p><strong>Telefone:</strong> {{ $paciente->telefone }}</p>
            <p><strong>Endereço:</strong> {{ $paciente->endereco }}</p>
            <p>
                <strong>Data de Nascimento:</strong> 
                {{ \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') }}
            </p>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.pacientes') }}" class="btn btn-secondary btn-sm">
                    Voltar
                </a>

                <a href="{{ route('pacientes.edit', $paciente->id) }}" 
                   class="btn btn-primary btn-sm">
                    Editar
                </a>
            </div>

        </div>

    </div>
</div>

@endsection