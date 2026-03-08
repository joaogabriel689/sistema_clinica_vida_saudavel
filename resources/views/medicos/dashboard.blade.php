@extends('layouts.base')

@section('title', 'Painel do Médico')

@section('content')

<div class="container py-4">

    <h2 class="mb-2">Painel do Médico</h2>
    <p class="text-muted">Olá, Dr(a). {{ $medico->nome }} 👋</p>


    {{-- Informações do Médico --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="mb-3">Seus Dados</h5>

            <div class="row">

                <div class="col-md-4">
                    <strong>Nome</strong>
                    <p class="text-muted">{{ $medico->nome }}</p>
                </div>

                <div class="col-md-4">
                    <strong>CRM</strong>
                    <p class="text-muted">{{ $medico->crm ?? '—' }}</p>
                </div>

                <div class="col-md-4">
                    <strong>Especialidade</strong>
                    <p class="text-muted">
                        {{ $medico->especialidade->nome ?? '—' }}
                    </p>
                </div>

            </div>

        </div>
    </div>


    {{-- Agenda do Dia --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Agenda de Hoje</h5>

                <span class="badge bg-primary">
                    {{ $agenda_medico_hoje->count() }} consultas
                </span>
            </div>


            <div class="table-responsive">

                <table class="table table-striped align-middle">

                    <thead>
                        <tr>
                            <th>Horário</th>
                            <th>Paciente</th>
                            <th>Status</th>
                            <th width="120">Ação</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($agenda_medico_hoje as $consulta)

                            <tr>

                                <td>
                                    {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('H:i') }}
                                </td>

                                <td>
                                    {{ $consulta->paciente->nome ?? 'Paciente não encontrado' }}
                                </td>

                                <td>

                                    @if($consulta->status == 'confirmada')
                                        <span class="badge bg-success">Confirmada</span>

                                    @elseif($consulta->status == 'cancelada')
                                        <span class="badge bg-danger">Cancelada</span>

                                    @else
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('consultas.show', $consulta->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma consulta agendada para hoje
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

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