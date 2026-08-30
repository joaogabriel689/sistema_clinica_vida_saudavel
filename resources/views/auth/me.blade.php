{{-- ==========================================
     me.blade.php — Perfil do Usuário
=========================================== --}}
@extends('layouts.base')
@section('title', 'Meu Perfil')
@section('content')

<div class="page-header fade-in">
    <div>
        <h2>Meu Perfil</h2>
        <p>Suas informações de conta e dados profissionais</p>
    </div>
</div>

<div class="row g-3">

    {{-- AVATAR CARD --}}
    <div class="col-lg-3">
        <div class="card text-center fade-in fade-in-1">
            <div class="card-body py-4">
                <div style="width:72px;height:72px;background:linear-gradient(135deg,#16a34a,#166534);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto 14px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div style="font-weight:700;font-size:15px;margin-bottom:4px;">{{ $user->name }}</div>
                <div style="font-size:12.5px;color:#6b7280;">{{ $user->email }}</div>
                <div class="mt-2">
                    <span class="badge" style="background:#f0fdf4;color:#166534;font-size:11px;">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="col-lg-9">

        {{-- CONTA --}}
        <div class="card mb-3 fade-in fade-in-2">
            <div class="card-header">
                <i class="bi bi-person-circle me-2 text-success"></i>Informações da Conta
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td style="width:160px;font-weight:600;color:#6b7280;font-size:13px;">Nome</td>
                            <td style="font-size:13.5px;">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Email</td>
                            <td style="font-size:13.5px;">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:#6b7280;font-size:13px;">Perfil</td>
                            <td>
                                <span class="badge" style="background:#f0fdf4;color:#166534;">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ADMIN: CLÍNICA & PERSONALIZAÇÃO --}}
        @if($user->role === 'admin')
        <div class="card fade-in fade-in-3 mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-palette me-2 text-success"></i>Dados & Personalização da Página da Clínica</span>
                @if($clinica && $clinica->slug)
                    <a href="{{ route('clinica.public', $clinica->slug) }}" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Ver Landing Page Pública
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($clinica)
                <form action="{{ route('admin.update_clinica') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-13">Nome da Clínica</label>
                            <input type="text" name="nome" class="form-control fs-14" value="{{ old('nome', $clinica->nome) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-13">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control fs-14" value="{{ old('cnpj', $clinica->cnpj) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-13">Telefone Principal</label>
                            <input type="text" name="telefone" class="form-control fs-14" value="{{ old('telefone', $clinica->telefone) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-13">Endereço Completo</label>
                            <input type="text" name="endereco" class="form-control fs-14" value="{{ old('endereco', $clinica->endereco) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-13"><i class="bi bi-globe me-1 text-primary"></i> Domínio Personalizado (CNAME)</label>
                            <input type="text" name="custom_domain" class="form-control fs-14" placeholder="ex: agendar.suaclinica.com.br" value="{{ old('custom_domain', $clinica->custom_domain) }}">
                        </div>

                        <hr class="my-3 text-muted">
                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-brush me-1"></i> Personalização Visual & Marca (Armazenamento S3)</h6>

                        <div class="col-md-4">
                            <label class="form-label fw-bold fs-13">Cor do Tema (Primária)</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" name="cor_primaria" class="form-control form-control-color" value="{{ old('cor_primaria', $clinica->cor_primaria ?? '#059669') }}" title="Escolha a cor principal">
                                <input type="text" class="form-control fs-13" value="{{ $clinica->cor_primaria ?? '#059669' }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold fs-13">Logo da Clínica (Upload S3)</label>
                            <input type="file" name="logo_file" class="form-control fs-14" accept="image/*">
                            <div class="form-text fs-12">Ou informe uma URL externa:</div>
                            <input type="text" name="logo_url" class="form-control fs-13" placeholder="https://exemplo.com/logo.png" value="{{ old('logo_url', $clinica->logo_url) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold fs-13">Banner de Fundo (Upload S3)</label>
                            <input type="file" name="banner_file" class="form-control fs-14" accept="image/*">
                            <div class="form-text fs-12">Ou informe uma URL externa:</div>
                            <input type="text" name="banner_url" class="form-control fs-13" placeholder="https://exemplo.com/banner.jpg" value="{{ old('banner_url', $clinica->banner_url) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold fs-13">Apresentação / Descrição da Clínica</label>
                            <textarea name="descricao" class="form-control fs-14" rows="3" placeholder="Escreva uma breve apresentação que aparecerá no topo da sua página pública">{{ old('descricao', $clinica->descricao) }}</textarea>
                        </div>

                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-lg me-1"></i> Salvar Personalização
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-building-x" style="font-size:32px;color:#d1d5db;display:block;margin-bottom:10px;"></i>
                    <p class="text-muted mb-3">Nenhuma clínica cadastrada ainda.</p>
                    <a href="{{ route('admin.criar_clinica') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Cadastrar Clínica
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- MÉDICO: INFO PROFISSIONAL --}}
        @elseif($user->role === 'medico')
        <div class="card fade-in fade-in-3">
            <div class="card-header">
                <i class="bi bi-person-badge me-2 text-success"></i>Informações Profissionais
            </div>
            <div class="card-body">
                @if($medico)
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Nome</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->nome }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">CRM</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->crm }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Especialidade</div>
                            <div style="font-weight:600;font-size:14px;">{{ $medico->especialidade->nome ?? 'Não definida' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f9fafb;border:1px solid #f0f3f7;">
                            <div style="font-size:11.5px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Horário</div>
                            <div style="font-weight:600;font-size:14px;">
                                {{ $medico->horario_inicio }} — {{ $medico->horario_fim }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p class="text-muted">Informações do médico não encontradas.</p>
                @endif
            </div>
        </div>
        @endif

        {{-- SEGURANÇA E 2FA --}}
        <div class="card mt-3 fade-in fade-in-4">
            <div class="card-header fw-bold">
                <i class="bi bi-shield-lock me-2 text-emerald-600"></i>Segurança & Autenticação de Dois Fatores (2FA)
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h6 class="fw-bold m-0 text-slate-900">Autenticação de 2 Fatores (2FA via App Authenticator)</h6>
                        <p class="text-muted fs-13 m-0">Adicione uma camada extra de segurança para proteção dos dados da clínica</p>
                    </div>
                    <div>
                        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-2 fs-12 fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i> Proteção Ativa
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection