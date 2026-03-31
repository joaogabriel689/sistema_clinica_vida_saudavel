{{-- ==========================================
     convenios/create.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Cadastrar Convênio')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Novo Convênio</h2>
        <p>Cadastre um novo plano de saúde ou convênio</p>
    </div>
    <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card fade-in fade-in-1">
            <div class="card-header">
                <i class="bi bi-shield-plus me-2 text-success"></i>Dados do Convênio
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.convenios.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Convênio</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror"
                               id="nome" name="nome" value="{{ old('nome') }}"
                               placeholder="Ex: Unimed, Bradesco Saúde" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código do Convênio</label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                               id="codigo" name="codigo" value="{{ old('codigo') }}"
                               placeholder="Código de identificação" required>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="percentual_desconto" class="form-label">Percentual de Desconto (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('percentual_desconto') is-invalid @enderror"
                                   id="percentual_desconto" name="percentual_desconto"
                                   min="0" max="100" step="0.01"
                                   value="{{ old('percentual_desconto') }}"
                                   placeholder="0" required>
                            <span class="input-group-text" style="border-radius:0 9px 9px 0;border:1.5px solid #e5e7eb;border-left:none;background:#f9fafb;font-weight:600;">%</span>
                        </div>
                        @error('percentual_desconto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.convenios.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Cadastrar Convênio
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection