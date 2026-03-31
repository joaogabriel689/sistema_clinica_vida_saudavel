{{-- ==========================================
     consultas/edit.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Editar Consulta')
@section('content')

<style>
.form-section { background:#f9fafb; border-radius:12px; padding:20px; margin-bottom:16px; border:1px solid #f0f3f7; }
.form-section-title { font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#9ca3af; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.form-section-title i { font-size:14px; color:#16a34a; }
</style>

<div class="page-header fade-in">
    <div>
        <h2>Editar Consulta <span style="color:#9ca3af;font-weight:400;">#{{ $consulta->id }}</span></h2>
        <p>Atualize os dados do agendamento</p>
    </div>
    <a href="{{ route('consultas.list') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card fade-in fade-in-1">
            <div class="card-body p-4">

                <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-person"></i> Paciente</div>
                        <div class="col-12">
                            <label class="form-label">Paciente</label>
                            <select name="paciente_id" class="form-select" required>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}"
                                        {{ $consulta->paciente_id == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-person-badge"></i> Especialidade & Médico</div>
                        <div class="row g-3">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-12">
                                <div id="horario_medico" class="d-flex align-items-center gap-2 p-3 rounded-3"
                                     style="background:#f0fdf4;border:1px solid #bbf7d0;font-size:13.5px;color:#166534;">
                                    <i class="bi bi-clock"></i> <span>Carregando horário...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-shield-check"></i> Convênio</div>
                        <select name="convenio_id" class="form-select">
                            @foreach($convenios as $convenio)
                                <option value="{{ $convenio->id }}"
                                    {{ $consulta->convenio_id == $convenio->id ? 'selected' : '' }}>
                                    {{ $convenio->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-calendar-event"></i> Data & Horário</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Data e Hora Início</label>
                                <input type="datetime-local" name="data_hora_inicio" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($consulta->data_hora_inicio)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Data e Hora Fim</label>
                                <input type="datetime-local" name="data_hora_fim" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($consulta->data_hora_fim)->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('consultas.list') }}" class="btn btn-secondary">Cancelar</a>
                        <button class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Atualizar Consulta
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let especialidadeSelect = document.getElementById('especialidade_id');
    let medicoSelect = document.getElementById('medico_id');
    let horarioDiv = document.getElementById('horario_medico');

    function carregarMedicos(especialidadeId) {
        fetch('/api/medicos/' + especialidadeId)
        .then(r => r.json())
        .then(data => {
            medicoSelect.innerHTML = '';
            data.forEach(m => { medicoSelect.innerHTML += `<option value="${m.id}">${m.nome}</option>`; });
        });
    }

    function carregarHorario(medicoId) {
        fetch('/api/medico/' + medicoId + '/horarios')
        .then(r => r.json())
        .then(data => {
            horarioDiv.innerHTML = `<i class="bi bi-clock"></i> <span><strong>Atendimento:</strong> ${data.inicio} até ${data.fim}</span>`;
        });
    }

    especialidadeSelect.addEventListener('change', function() { carregarMedicos(this.value); });
    medicoSelect.addEventListener('change', function() { carregarHorario(this.value); });
    carregarHorario(medicoSelect.value);
});
</script>

@endsection