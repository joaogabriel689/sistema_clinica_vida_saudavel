@extends('layouts.base')

@section('content')

<div class="container">

<h3>Editar Consulta</h3>

<form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="paciente_id" class="form-label">Paciente</label>
        <select name="paciente_id" class="form-select" required>
            @foreach($pacientes as $paciente)
                <option value="{{ $paciente->id }}"
                    {{ $consulta->paciente_id == $paciente->id ? 'selected' : '' }}>
                    {{ $paciente->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Especialidade</label>
        <select id="especialidade_id" name="especialidade_id" class="form-select" required>

            @foreach($especialidades as $especialidade)

                <option value="{{ $especialidade->id }}"
                    {{ $consulta->especialidade_id == $especialidade->id ? 'selected' : '' }}>
                    {{ $especialidade->nome }}
                </option>

            @endforeach

        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Médico</label>
        <select id="medico_id" name="medico_id" class="form-select" required>

            @foreach($medicos as $medico)

                <option value="{{ $medico->id }}"
                    {{ $consulta->medico_id == $medico->id ? 'selected' : '' }}>
                    {{ $medico->nome }}
                </option>

            @endforeach

        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Horário do Médico</label>

        <div id="horario_medico" class="alert alert-info">
            Carregando horário...
        </div>

    </div>


    <div class="mb-3">
        <label class="form-label">Convênio</label>

        <select name="convenio_id" class="form-select">

            @foreach($convenios as $convenio)

                <option value="{{ $convenio->id }}"
                    {{ $consulta->convenio_id == $convenio->id ? 'selected' : '' }}>
                    {{ $convenio->nome }}
                </option>

            @endforeach

        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Data e Hora Início</label>

        <input
        type="datetime-local"
        name="data_hora_inicio"
        value="{{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('Y-m-d\TH:i') }}"
        class="form-control"
        required>
    </div>


    <div class="mb-3">
        <label class="form-label">Data e Hora Fim</label>

        <input
        type="datetime-local"
        name="data_hora_fim"
        value="{{ \Carbon\Carbon::parse($consulta->data_hora_fim)->format('Y-m-d\TH:i') }}"
        class="form-control"
        required>

    </div>


    <button class="btn btn-primary">
        Atualizar Consulta
    </button>

</form>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

let especialidadeSelect = document.getElementById('especialidade_id');
let medicoSelect = document.getElementById('medico_id');
let horarioDiv = document.getElementById('horario_medico');

function carregarMedicos(especialidadeId){

fetch('/api/medicos/' + especialidadeId)

.then(response => response.json())

.then(data => {

medicoSelect.innerHTML = '';

data.forEach(function(medico){

medicoSelect.innerHTML +=
`<option value="${medico.id}">${medico.nome}</option>`;

});

});

}


function carregarHorario(medicoId){

fetch('/api/medico/' + medicoId + '/horarios')

.then(response => response.json())

.then(data => {

horarioDiv.innerHTML =
`<strong>Atendimento:</strong> ${data.inicio} até ${data.fim}`;

});

}


// trocar especialidade
especialidadeSelect.addEventListener('change', function(){

carregarMedicos(this.value);

});


// trocar médico
medicoSelect.addEventListener('change', function(){

carregarHorario(this.value);

});


// carregar horário inicial
carregarHorario(medicoSelect.value);

});

</script>


@endsection