@extends('layouts.base')

@section('title', 'Painel Administrativo')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Painel Administrativo</h2>

    {{-- Cards de resumo --}}
    <div class="row g-4 mb-4">
        @if($clinica == null)

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">criar clinica</h6>
                    <a href="{{ route('admin.criar_clinica') }}" class="small">Gerenciar</a>
                </div>
            </div>
        </div>

        @endif
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Convenios</h6>
                    <h3>{{ $quantidade_convenios }}</h3>
                    <a href="{{ route('admin.convenios.index') }}" class="small">Gerenciar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Consultas Hoje</h6>
                    <h3>--</h3>
                    <a href="#" class="small">Ver agenda</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Médicos Ativos</h6>
                    <h3>{{ $quantidade_medicos }}</h3>
                    <a href="{{ route('admin.medicos') }}" class="small">Gerenciar médicos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Recepcionistas</h6>
                    <h3>{{ $quantidade_recepcionistas }}</h3>
                    <a href="{{ route('admin.recepcionistas') }}" class="small">Gerenciar</a>
                </div>
            </div>
        </div>

    </div>

    {{-- Área futura --}}
    <div class="row g-4">

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Relatórios</h5>
                    <p class="text-muted">Em breve: relatórios de atendimentos, crescimento mensal e faturamento.</p>
                    <button class="btn btn-outline-primary btn-sm">Acessar relatórios</button>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Insights</h5>
                    <p class="text-muted">Área reservada para análises estratégicas da clínica.</p>
                    <button class="btn btn-outline-success btn-sm">Ver insights</button>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection