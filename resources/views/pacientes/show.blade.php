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
<h2>{{ $paciente->nome }}</h2>

<h4>Histórico de Consultas</h4>

<table class="table">
<thead>
<tr>
<th>Data</th>
<th>Médico</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@foreach($paciente->consultas as $consulta)

<tr>
<td>{{ $consulta->data_hora_inicio }}</td>
<td>{{ $consulta->medico->nome }}</td>
<td>{{ $consulta->status }}</td>
</tr>

@endforeach
</tbody>
</table>

@endsection