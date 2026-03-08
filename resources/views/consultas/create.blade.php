@extends('layouts.base')

@section('content')

<div class="container">

<h3>Agendar Consulta</h3>

<form action="{{ route('consultas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="paciente_id" class="form-label">Paciente</label>
        <select name="paciente_id" id="paciente_id" class="form-select" required>
            <option value="">Selecione um paciente</option>
            @foreach($pacientes as $paciente)
                <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="especialidade_id" class="form-label">Especialidade</label>
        <select name="especialidade_id" id="especialidade_id" class="form-select" required>
            <option value="">Selecione uma especialidade</option>
            @foreach($especialidades as $especialidade)
                <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="medico_id" class="form-label">Médico</label>
        <select name="medico_id" id="medico_id" class="form-select" required>
            <option value="">Selecione um médico</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Horário de Atendimento</label>
        <div id="horario_medico" class="alert alert-info">
            Selecione um médico para visualizar o horário
        </div>
    </div>

    <div class="mb-3">
        <label for="convenio_id" class="form-label">Convênio</label>
        <select name="convenio_id" id="convenio_id" class="form-select" required>
            <option value="">Selecione um convênio</option>
            @foreach($convenios as $convenio)
                <option value="{{ $convenio->id }}">{{ $convenio->nome }}</option>
            @endforeach
        </select>
    </div>
        <div class="mb-3">
        <label for="convenio_id" class="form-label">Convênio</label>
            <input type="number" name="valor" placeholder="valor">
    </div>

    <div class="mb-3">
        <label for="data_hora_inicio" class="form-label">Data e Hora de Início</label>
        <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="data_hora_fim" class="form-label">Data e Hora de Fim</label>
        <input type="datetime-local" name="data_hora_fim" id="data_hora_fim" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Agendar Consulta</button>

</form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    let especialidadeSelect = document.getElementById('especialidade_id');
    let medicoSelect = document.getElementById('medico_id');
    let horarioDiv = document.getElementById('horario_medico');

    // carregar médicos pela especialidade
    especialidadeSelect.addEventListener('change', function () {

        let especialidadeId = this.value;

        medicoSelect.innerHTML = '<option>Carregando...</option>';

        fetch('/api/medicos/' + especialidadeId)
        .then(response => response.json())
        .then(data => {

            medicoSelect.innerHTML = '<option value="">Selecione um médico</option>';

            data.forEach(function(medico){

                medicoSelect.innerHTML +=
                `<option value="${medico.id}">${medico.nome}</option>`;

            });

        });

    });


    // mostrar horário do médico
    medicoSelect.addEventListener('change', function () {

        let medicoId = this.value;

        fetch('/api/medico/' + medicoId + '/horarios')
        .then(response => response.json())
        .then(data => {

            horarioDiv.innerHTML =
            `<strong>Atendimento:</strong> ${data.inicio} até ${data.fim}`;

        });

    });

});

</script>

@endsection