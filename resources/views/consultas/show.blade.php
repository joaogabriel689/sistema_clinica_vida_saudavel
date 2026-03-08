@extends('layouts.base')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detalhes da Consulta</h2>

        <div>
            <a href="{{ route('consultas.edit', $consulta->id) }}" class="btn btn-warning">
                Editar
            </a>

            <a href="{{ route('consultas.list') }}" class="btn btn-secondary">
                Voltar
            </a>
        </div>
    </div>


    <div class="card">

        <div class="card-body">

            <h4 class="mb-3">Informações da Consulta</h4>

            <table class="table table-bordered">

                <tr>
                    <th width="200">ID</th>
                    <td>{{ $consulta->id }}</td>
                </tr>

                <tr>
                    <th>Data de Início</th>
                    <td>
                        {{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('d/m/Y H:i') }}
                    </td>
                </tr>

                <tr>
                    <th>Data de Fim</th>
                    <td>
                        {{ \Carbon\Carbon::parse($consulta->data_hora_fim)->format('d/m/Y H:i') }}
                    </td>
                </tr>

                <tr>
                    <th>Valor</th>
                    <td>
                        R$ {{ number_format($consulta->valor, 2, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        {{ ucfirst($consulta->status ?? 'pendente') }}
                    </td>
                </tr>

            </table>


            <h4 class="mt-4 mb-3">Paciente</h4>

            <table class="table table-bordered">

                <tr>
                    <th width="200">Nome</th>
                    <td>{{ $paciente->nome }}</td>
                </tr>

                <tr>
                    <th>Telefone</th>
                    <td>{{ $paciente->telefone ?? '—' }}</td>
                </tr>

                <tr>
                    <th>CPF</th>
                    <td>{{ $paciente->cpf ?? '—' }}</td>
                </tr>

            </table>


            <h4 class="mt-4 mb-3">Médico</h4>

            <table class="table table-bordered">

                <tr>
                    <th width="200">Nome</th>
                    <td>{{ $medico->nome }}</td>
                </tr>

                <tr>
                    <th>Especialidade</th>
                    <td>{{ $consulta->especialidade->nome ?? '—' }}</td>
                </tr>

                <tr>
                    <th>CRM</th>
                    <td>{{ $medico->crm ?? '—' }}</td>
                </tr>

            </table>


            <h4 class="mt-4 mb-3">Convênio</h4>

            <table class="table table-bordered">

                <tr>
                    <th width="200">Nome</th>
                    <td>{{ $convenio->nome ?? 'Particular' }}</td>
                </tr>

                <tr>
                    <th>Desconto</th>
                    <td>
                        {{ $convenio->desconto ?? 0 }}%
                    </td>
                </tr>

            </table>


            <h4 class="mt-4 mb-3">Observações</h4>

            <div class="border p-3 rounded bg-light">
                {{ $consulta->observacoes ?? 'Nenhuma observação registrada.' }}
            </div>

        </div>

    </div>

</div>

@endsection