{{-- ==========================================
     me.blade.php — Perfil do Usuário
=========================================== --}}
@extends('layouts.base')
@section('title', 'Meu Perfil')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Meu Perfil</h2>
        <p>Suas informações de conta e dados profissionais</p>
    </div>
</div>

<div class="row g-3">

    {{-- AVATAR CARD --}}
    <div class="col-lg-3">
        <div class="card text-center fade-in fade-in-1">
            <div class="card-body py-4">
                <div style="width:72px;height:72px;background:linear-gradient(135deg,#16a34a,#166534);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto 14px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div style="font-weight:700;font-size:15px;margin-bottom:4px;">{{ $user->name }}</div>
                <div style="font-size:12.5px;color:#6b7280;">{{ $user->email }}</div>
                <div class="mt-2">
                    <span class="badge" style="background:#f0fdf4;color:#166534;font-size:11px;">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="col-lg-9">

        {{-- CONTA --}}
        <div class="card mb-3 fade-in fade-in-2">
            <div class="card-header">
                <i class="bi bi-person-circle me-2 text-success"></i>Informações da Conta
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td style="width:160px;font-weight:600;color:#6b7280;font-size:13px;">Nome</td>
                            <td style="font-size:13.5px;">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Email</td>
                            <td style="font-size:13.5px;">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Perfil</td>
                            <td>
                                <span class="badge" style="background:#f0fdf4;color:#166534;">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ADMIN: CLÍNICA --}}
        @if($user->role === 'admin')
        <div class="card fade-in fade-in-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-building me-2 text-primary"></i>Informações da Clínica</span>
            </div>
            <div class="card-body">
                @if($clinica)
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Nome</div>
                            <div style="font-weight:600;font-size:14px;">{{ $clinica->nome }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">CNPJ</div>
                            <div style="font-weight:600;font-size:14px;">{{ $clinica->cnpj }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Telefone</div>
                            <div style="font-weight:600;font-size:14px;">{{ $clinica->telefone }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Endereço</div>
                            <div style="font-weight:600;font-size:14px;">{{ $clinica->endereco }}</div>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-building-x" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:10px;"></i>
                    <p class="text-muted mb-3">Nenhuma clínica cadastrada ainda.</p>
                    <a href="{{ route('admin.criar_clinica') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Cadastrar Clínica
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- MÉDICO: INFO PROFISSIONAL --}}
        @elseif($user->role === 'medico')
        <div class="card fade-in fade-in-3">
            <div class="card-header">
                <i class="bi bi-person-badge me-2 text-success"></i>Informações Profissionais
            </div>
            <div class="card-body">
                @if($medico)
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Nome</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->nome }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">CRM</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->crm }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Especialidade</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->especialidade->nome ?? 'Não definida' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Horário</div>
                            <div style="font-weight:600;font-size:14px;">
                                {{ $medico->horario_inicio }} — {{ $medico->horario_fim }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p class="text-muted">Informações do médico não encontradas.</p>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

@endsection