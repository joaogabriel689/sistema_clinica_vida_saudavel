{{-- ==========================================
     admin/criar_clinica.blade.php
=========================================== --}}
@extends('layouts.base')
@section('title', 'Cadastrar Clínica')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Cadastrar Clínica</h2>
        <p>Configure as informações da sua unidade de saúde</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="card mb-3 fade-in fade-in-1" style="background:linear-gradient(135deg,#0f1f14,#166534);border:none;">
            <div class="card-body p-4" style="color:#fff;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">
                        🏥
                    </div>
                    <div>
                        <div style="font-weight:800;font-size:16px;">Bem-vindo ao Vida Saudável</div>
                        <div style="font-size:13px;opacity:.7;margin-top:2px;">
                            Cadastre sua clínica para começar a usar todas as funcionalidades do sistema.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card fade-in fade-in-2">
            <div class="card-header">
                <i class="bi bi-building me-2 text-success"></i>Dados da Clínica
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.store_clinica') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nome da Clínica</label>
                            <input type="text" name="nome"
                                   class="form-control @error('nome') is-invalid @enderror"
                                   value="{{ old('nome') }}"
                                   placeholder="Ex: Clínica Vida Saudável" required>
                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">CNPJ</label>
                            <input type="text" name="cnpj"
                                   class="form-control @error('cnpj') is-invalid @enderror"
                                   value="{{ old('cnpj') }}"
                                   placeholder="00.000.000/0001-00" required>
                            @error('cnpj')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone"
                                   class="form-control @error('telefone') is-invalid @enderror"
                                   value="{{ old('telefone') }}"
                                   placeholder="(00) 00000-0000" required>
                            @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Endereço completo</label>
                            <input type="text" name="endereco"
                                   class="form-control @error('endereco') is-invalid @enderror"
                                   value="{{ old('endereco') }}"
                                   placeholder="Rua, número, bairro, cidade — Estado" required>
                            @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary" style="padding:13px;">
                            <i class="bi bi-building-check me-2"></i> Cadastrar Clínica e Continuar
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection