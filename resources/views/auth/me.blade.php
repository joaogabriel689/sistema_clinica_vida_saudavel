@extends('layouts.base')

@section('title', 'Meu Perfil')

@section('content')

<div class="container">
    <h2 class="mb-4">Meu Perfil</h2>

    {{-- =========================
        INFORMAÇÕES DO USUÁRIO
    ========================== --}}
    <div class="card shadow-sm p-4 mb-4">
        <h4 class="mb-3">Informações da Conta</h4>

        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Perfil:</strong> {{ ucfirst($user->role) }}</p>
    </div>


    {{-- =========================
        ADMIN
    ========================== --}}
    @if($user->role === 'admin')

        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Informações da Clínica</h4>

            @if($clinica)
                <p><strong>Nome:</strong> {{ $clinica->nome }}</p>
                <p><strong>CNPJ:</strong> {{ $clinica->cnpj }}</p>
                <p><strong>Telefone:</strong> {{ $clinica->telefone }}</p>
                <p><strong>Endereço:</strong> {{ $clinica->endereco }}</p>
            @else
                <p class="text-muted">Nenhuma clínica cadastrada.</p>
                <a href="{{ route('admin.criar_clinica') }}" class="btn btn-primary btn-sm">
                    Criar Clínica
                </a>
            @endif
        </div>

    {{-- =========================
        MÉDICO
    ========================== --}}
    @elseif($user->role === 'medico')

        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Informações Profissionais</h4>

            @if($medico)
                <p><strong>Nome:</strong> {{ $medico->nome }}</p>
                <p><strong>CRM:</strong> {{ $medico->crm }}</p>
                <p><strong>Telefone:</strong> {{ $medico->telefone }}</p>

                <p>
                    <strong>Especialidade:</strong>
                    {{ $medico->especialidade->nome ?? 'Não definida' }}
                </p>

                <p>
                    <strong>Horário de Atendimento:</strong>
                    {{ $medico->horario_inicio }} às {{ $medico->horario_fim }}
                </p>
            @else
                <p class="text-muted">Informações do médico não encontradas.</p>
            @endif
        </div>



    @endif


    {{-- =========================
        DASHBOARD
    ========================== --}}


</div>

@endsection