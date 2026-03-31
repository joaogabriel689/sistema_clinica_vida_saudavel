@extends('layouts.base')
@section('title', 'Agendar Consulta')

@section('content')

<style>
.form-section {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #f0f3f7;
    transition: all 0.2s ease;
}
.form-section:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
}
.form-section-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7280;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-section-title i {
    color: #16a34a;
}
.card {
    border: none;
    border-radius: 16px;
}
.btn-primary {
    background-color: #16a34a;
    border: none;
}
.btn-primary:hover {
    background-color: #166534;
}
.fade-in {
    animation: fadeIn 0.4s ease-in-out;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>

<div class="page-header d-flex justify-content-between align-items-center mb-4 fade-in">
    <div>
        <h3 class="mb-1">Agendar Consulta</h3>
        <small class="text-muted">Preencha os dados para criar um novo agendamento</small>
    </div>
    <a href="{{ route('consultas.list') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow-sm fade-in">
            <div class="card-body p-4">

                <form action="{{ route('consultas.store') }}" method="POST">
                    @csrf

                    {{-- PACIENTE --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-person"></i> Paciente & Convênio
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Paciente</label>
                                <select name="paciente_id" id="paciente_id" class="form-select" required>
                                    <option value="">Selecione</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Convênio</label>
                                <select name="convenio_id" id="convenio_id" class="form-select" required>
                                    <option value="">Selecione</option>
                                    @foreach($convenios as $convenio)
                                        <option value="{{ $convenio->id }}">{{ $convenio->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Valor (R$)</label>
                                <input type="number" name="valor" class="form-control" step="0.01" placeholder="0,00">
                            </div>
                        </div>
                    </div>

                    {{-- MÉDICO --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-person-badge"></i> Especialidade & Médico
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Especialidade</label>
                                <select name="especialidade_id" id="especialidade_id" class="form-select" required>
                                    <option value="">Selecione</option>
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Médico</label>
                                <select name="medico_id" id="medico_id" class="form-select" required disabled>
                                    <option value="">Selecione uma especialidade</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <div id="horario_medico"
                                     class="d-none align-items-center gap-2 p-3 rounded-3"
                                     style="background:#f0fdf4;border:1px solid #bbf7d0;font-size:13px;color:#166534;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HORÁRIO --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-calendar-event"></i> Data & Horário
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Início</label>
                                <input type="datetime-local" name="data_hora_inicio" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fim</label>
                                <input type="datetime-local" name="data_hora_fim" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('consultas.list') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-calendar-check me-1"></i> Agendar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const especialidade = document.getElementById('especialidade_id');
    const medico = document.getElementById('medico_id');
    const horario = document.getElementById('horario_medico');

    especialidade.addEventListener('change', function () {

        const id = this.value;

        medico.innerHTML = '<option>Carregando...</option>';
        medico.disabled = true;

        horario.classList.add('d-none');

        if (!id) {
            medico.innerHTML = '<option>Selecione uma especialidade</option>';
            return;
        }

        fetch(`/api/medicos/${id}`)
            .then(r => {
                if (!r.ok) throw new Error();
                return r.json();
            })
            .then(data => {

                medico.innerHTML = '<option value="">Selecione</option>';
                medico.disabled = false;

                if (data.length === 0) {
                    medico.innerHTML = '<option>Nenhum médico encontrado</option>';
                    return;
                }

                let lista = Array.isArray(data) ? data : Object.values(data);

                lista.forEach(m => {
                    medico.innerHTML += `<option value="${m.id}">${m.nome}</option>`;
                });

            })
            .catch(() => {
                medico.innerHTML = '<option>Erro ao carregar</option>';
            });
    });

    medico.addEventListener('change', function () {

        const id = this.value;

        horario.classList.add('d-none');

        if (!id) return;

        horario.classList.remove('d-none');
        horario.innerHTML = `<i class="bi bi-clock"></i> Carregando horários...`;

        fetch(`/api/medico/${id}/horarios`)
            .then(r => r.json())
            .then(data => {
                horario.innerHTML = `
                    <i class="bi bi-clock"></i>
                    Atendimento: <strong>${data.inicio}</strong> até <strong>${data.fim}</strong>
                `;
            })
            .catch(() => {
                horario.innerHTML = `Erro ao carregar horários`;
            });

    });

});
</script>

@endsection