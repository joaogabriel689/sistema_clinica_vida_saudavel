@extends('layouts.base')
@section('title', 'Detalhes da Consulta')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Detalhes da Consulta <span style="color:#9ca3af;font-weight:400;">#{{ $consulta->id }}</span></h2>
        <p>Informações completas do agendamento</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('consultas.edit', $consulta->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Editar
        </a>
        <a href="{{ route('consultas.list') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>
</div>

<div class="row g-3 fade-in fade-in-1">

    {{-- LEFT --}}
    <div class="col-lg-8">

        {{-- CONSULTA INFO --}}
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-calendar2-check me-2 text-success"></i>Informações da Consulta
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td style="width:180px;font-weight:600;color:#6b7280;font-size:13px;">Status</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'confirmada' => 'bg-success',
                                        'cancelada'  => 'bg-danger',
                                        'realizada'  => 'bg-primary',
                                        'agendada'   => 'bg-warning text-dark',
                                    ];
                                    $sc = $statusColors[$consulta->status ?? 'agendada'] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $sc }}">{{ ucfirst($consulta->status ?? 'Pendente') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Data de Início</td>
                            <td style="font-size:13.5px;">
                                <i class="bi bi-clock me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Data de Fim</td>
                            <td style="font-size:13.5px;">
                                <i class="bi bi-clock me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($consulta->data_hora_fim)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Valor</td>
                            <td style="font-size:15px;font-weight:700;color:#16a34a;">
                                R$ {{ number_format($consulta->valor, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Observações</td>
                            <td style="font-size:13.5px;color:#6b7280;">
                                {{ $consulta->observacoes ?? 'Nenhuma observação registrada.' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PACIENTE --}}
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person me-2 text-primary"></i>Paciente
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td style="width:180px;font-weight:600;color:#6b7280;font-size:13px;">Nome</td>
                            <td style="font-weight:600;">{{ $paciente->nome }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Telefone</td>
                            <td style="font-size:13.5px;">{{ $paciente->telefone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">CPF</td>
                            <td style="font-size:13.5px;">{{ $paciente->cpf ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MÉDICO --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-badge me-2 text-success"></i>Médico
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td style="width:180px;font-weight:600;color:#6b7280;font-size:13px;">Nome</td>
                            <td style="font-weight:600;">{{ $medico->nome }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Especialidade</td>
                            <td>
                                <span class="badge" style="background:#f0fdf4;color:#166534;">
                                    {{ $consulta->especialidade->nome ?? '—' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">CRM</td>
                            <td style="font-size:13.5px;">{{ $medico->crm ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-shield-check me-2 text-warning"></i>Convênio
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f9fafb;">
                    <div style="width:42px;height:42px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;">
                        🛡️
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:14px;">{{ $convenio->nome ?? 'Particular' }}</div>
                        <div style="font-size:12.5px;color:#6b7280;">Desconto: {{ $convenio->desconto ?? 0 }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection