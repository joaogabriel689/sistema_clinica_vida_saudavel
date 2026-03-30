@extends('layouts.base')

@section('title', 'Painel da Recepção')

@section('content')

<div class="container py-4">

    <h2 class="mb-2">Painel da Recepção</h2>
    <p class="text-muted">Olá, {{ auth()->user()->name }} 👋</p>

    {{-- Cards Resumo --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Pacientes Cadastrados</h6>
                    <h4>{{ $quantidade_pacientes }}</h4>
                    <a href="{{ route('admin.pacientes') }}" class="small">Ver lista</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Médicos Ativos</h6>
                    <h4>{{ $quantidade_medicos }}</h4>
                    <a href="{{ route('admin.medicos') }}" class="small">Ver médicos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Consultas Hoje</h6>
                    <h4>{{ $quantidade_consultas_hoje }}</h4>
                    <a href="{{ route('consultas.list') }}" class="small">Ver agenda</a>
                </div>
            </div>
        </div>

    </div>

    {{-- Agenda Geral --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Agenda de Hoje</h5>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">

                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Paciente</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($agendas_hoje as $consulta)

                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }}
                                </td>

                                <td>
                                    {{ $consulta->medico->nome ?? '—' }}
                                </td>

                                <td>
                                    {{ $consulta->paciente->nome ?? '—' }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Nenhuma consulta agendada hoje
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <p class="text-muted small mt-2">
                {{ $agendas_hoje->count() }} consultas agendadas para hoje.
            </p>

        </div>
    </div>

    {{-- Lista Rápida de Pacientes --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Pacientes Recentes</h5>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Cadastro</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pacientes_recentes as $paciente)

                            <tr>

                                <td>{{ $paciente->nome }}</td>

                                <td>{{ $paciente->telefone ?? '—' }}</td>

                                <td>
                                    {{ $paciente->created_at->format('d/m/Y') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Nenhum paciente recente
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <a href="{{ route('admin.pacientes') }}" class="btn btn-outline-primary btn-sm mt-2">
                Gerenciar Pacientes
            </a>

        </div>
    </div>

    {{-- Atalhos Rápidos --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Ações Rápidas</h5>

            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-sm">
                    Novo Paciente
                </a>

                <a href="{{ route('consultas.create') }}" class="btn btn-success btn-sm">
                    Agendar Consulta
                </a>

                <a href="{{ route('consultas.list') }}" class="btn btn-outline-secondary btn-sm">
                    Ver Agenda Completa
                </a>

            </div>
        </div>
    </div>

</div>



@endsection