{{-- ==========================================
     convenios/edit.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Editar Convênio')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Editar Convênio</h2>
        <p>Atualize as informações do plano</p>
    </div>
    <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card fade-in fade-in-1">
            <div class="card-header">
                <i class="bi bi-shield-check me-2 text-success"></i>{{ $convenio->nome }}
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.convenios.update', $convenio->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Convênio</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               required value="{{ $convenio->nome }}">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo"
                               required value="{{ $convenio->codigo }}">
                    </div>

                    <div class="mb-4">
                        <label for="percentual_desconto" class="form-label">Percentual de Desconto (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="percentual_desconto"
                                   name="percentual_desconto" min="0" max="100" required
                                   value="{{ $convenio->percentual_desconto }}">
                            <span class="input-group-text" style="border-radius:0 9px 9px 0;border:1.5px solid #e5e7eb;border-left:none;background:#f9fafb;font-weight:600;">%</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Atualizar Convênio
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection