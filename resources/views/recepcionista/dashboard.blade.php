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
                    <h4>--</h4>
                    <a href="{{ route('admin.pacientes') }}" class="small">Ver lista</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Médicos Ativos</h6>
                    <h4>--</h4>
                    <a href="#" class="small">Ver médicos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Consultas Hoje</h6>
                    <h4>--</h4>
                    <a href="#" class="small">Ver agenda</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Aguardando Atendimento</h6>
                    <h4>--</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- Agenda Geral --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Agenda Geral</h5>
            <p class="text-muted">
                Aqui aparecerá a lista de consultas agendadas com horário, paciente e médico.
            </p>
        </div>
    </div>

    {{-- Lista Rápida de Pacientes --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Pacientes Recentes</h5>

            <p class="text-muted">
                Lista resumida dos últimos pacientes cadastrados.
            </p>

            <a href="{{ route('admin.pacientes') }}" class="btn btn-outline-primary btn-sm">
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

                <a href="#" class="btn btn-success btn-sm">
                    Agendar Consulta
                </a>

                <a href="#" class="btn btn-outline-secondary btn-sm">
                    Ver Agenda Completa
                </a>
            </div>
        </div>
    </div>

</div>
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-danger position-fixed bottom-0 end-0 m-4">
        Sair
    </button>
</form>
@endsection