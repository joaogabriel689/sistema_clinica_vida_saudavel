{{-- ==========================================
     medicos/edit.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Editar Médico')
@section('content')

<style>
.form-section { background:#f9fafb; border-radius:12px; padding:20px; margin-bottom:16px; border:1px solid #f0f3f7; }
.form-section-title { font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#9ca3af; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.form-section-title i { font-size:14px; color:#16a34a; }
</style>

<div class="page-header fade-in">
    <div>
        <h2>Editar Médico</h2>
        <p>Atualize os dados de {{ $medico->nome }}</p>
    </div>
    <a href="{{ route('admin.medicos') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card fade-in fade-in-1">
            <div class="card-body p-4">
                <form action="{{ route('admin.medicos.update', $medico->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-person"></i> Dados Pessoais</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome completo</label>
                                <input type="text" name="nome"
                                       class="form-control @error('nome') is-invalid @enderror"
                                       value="{{ old('nome', $medico->nome) }}" required>
                                @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CRM</label>
                                <input type="text" name="crm"
                                       class="form-control @error('crm') is-invalid @enderror"
                                       value="{{ old('crm', $medico->crm) }}" required>
                                @error('crm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Especialidade</label>
                                <select name="especialidade"
                                        class="form-select @error('especialidade') is-invalid @enderror" required>
                                    <option value="">Selecione</option>
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{ $especialidade->id }}"
                                            {{ old('especialidade', $medico->especialidade_id) == $especialidade->id ? 'selected' : '' }}>
                                            {{ $especialidade->nome }}
                                        </option>
                                    @endforeach
                                    <option value="outra" {{ old('especialidade') == 'outra' ? 'selected' : '' }}>
                                        + Outra especialidade
                                    </option>
                                </select>
                                @error('especialidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $medico->user->email ?? '') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 d-none" id="novaEspecialidadeContainer">
                                <label class="form-label">Nova especialidade</label>
                                <input type="text" name="nova_especialidade"
                                       class="form-control @error('nova_especialidade') is-invalid @enderror"
                                       value="{{ old('nova_especialidade') }}">
                                @error('nova_especialidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title"><i class="bi bi-clock"></i> Horário de Atendimento</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Hora Início</label>
                                <input type="time" name="hora_inicio"
                                       class="form-control @error('hora_inicio') is-invalid @enderror"
                                       value="{{ old('hora_inicio', $medico->horario_inicio) }}" required>
                                @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" name="hora_fim"
                                       class="form-control @error('hora_fim') is-invalid @enderror"
                                       value="{{ old('hora_fim', $medico->horario_fim) }}" required>
                                @error('hora_fim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.medicos') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Atualizar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.querySelector('select[name="especialidade"]');
    const container = document.getElementById('novaEspecialidadeContainer');
    function toggle() { container.classList.toggle('d-none', select.value !== 'outra'); }
    select.addEventListener('change', toggle);
    toggle();
});
</script>

@endsection