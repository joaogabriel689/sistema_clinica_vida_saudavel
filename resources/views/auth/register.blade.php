<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Clínica — Vida Saudável SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --emerald-700: #047857;
            --obsidian-dark: #061610;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            margin: 0;
        }

        .auth-container {
            width: 100vw;
            min-height: 100vh;
            display: flex;
        }

        .auth-side-banner {
            width: 40%;
            background: radial-gradient(100% 100% at 50% 0%, #047857 0%, #061610 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 48px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .auth-side-banner::before {
            content: '';
            position: absolute;
            width: 450px; height: 450px;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.2) 0%, rgba(0,0,0,0) 70%);
            top: -150px; right: -100px;
            pointer-events: none;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo .icon-box {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #10b981, #047857);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        }

        .brand-logo .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }

        .banner-hero-text h1 {
            font-size: 34px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .step-list-saas {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .step-number {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(52, 211, 153, 0.2);
            border: 1px solid rgba(52, 211, 153, 0.4);
            color: #34d399;
            font-weight: 800;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-form-side {
            flex: 1;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
        }

        .auth-box-wrapper {
            width: 100%;
            max-width: 560px;
        }

        .auth-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .section-label-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #059669;
            background: #ecfdf5;
            padding: 4px 12px;
            border-radius: 99px;
            margin-bottom: 12px;
        }

        .form-control-custom {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
            padding: 11px 16px;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
            outline: none;
        }

        .btn-submit-auth {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            padding: 14px;
            border-radius: 12px;
            border: none;
            width: 100%;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-submit-auth:hover {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
        }

        @media (max-width: 991px) {
            .auth-side-banner { display: none; }
        }
    </style>
</head>
<body>

<div class="auth-container">
    <!-- LEFT SIDE BANNER -->
    <div class="auth-side-banner">
        <a href="{{ route('index') }}" class="brand-logo">
            <div class="icon-box"><i class="bi bi-heart-pulse-fill"></i></div>
            <div>
                <div class="brand-name">Vida Saudável</div>
                <small class="text-emerald-400 font-monospace text-uppercase" style="font-size:10px;">SaaS Platform</small>
            </div>
        </a>

        <div class="banner-hero-text">
            <h1>Crie sua clínica e teste 14 dias grátis</h1>
            <p>Setup automático em menos de 2 minutos. Sem necessidade de cartão de crédito no cadastro.</p>
        </div>

        <ul class="step-list-saas">
            <li class="step-item">
                <div class="step-number">1</div>
                <div>
                    <div class="fw-bold text-white fs-14">Crie sua conta Admin</div>
                    <small class="text-slate-300 fs-12">Seu acesso master à plataforma</small>
                </div>
            </li>
            <li class="step-item">
                <div class="step-number">2</div>
                <div>
                    <div class="fw-bold text-white fs-14">Cadastre a Clínica</div>
                    <small class="text-slate-300 fs-12">Ambiente isolado (Multi-Tenant)</small>
                </div>
            </li>
            <li class="step-item">
                <div class="step-number">3</div>
                <div>
                    <div class="fw-bold text-white fs-14">Conecte o WhatsApp</div>
                    <small class="text-slate-300 fs-12">Integração Z-API para confirmações</small>
                </div>
            </li>
        </ul>
    </div>

    <!-- RIGHT FORM SIDE -->
    <div class="auth-form-side">
        <div class="auth-box-wrapper">
            <h2 class="auth-title">Cadastrar Nova Clínica</h2>
            <p class="text-muted fs-14 mb-4">Preencha os dados do responsável e da clínica médica</p>

            <form method="POST" action="{{ route('auth-register') }}">
                @csrf

                <!-- SEÇÃO 1: CONTA ADMIN -->
                <div class="section-label-chip"><i class="bi bi-person-badge-fill"></i> 1. Dados do Administrador</div>
                
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="name" class="form-label fw-semibold text-slate-700 fs-13 mb-1">Nome do Gestor Responsável</label>
                        <input type="text"
                            class="form-control form-control-custom @error('name') is-invalid @enderror"
                            id="name" name="name"
                            value="{{ old('name') }}"
                            placeholder="Dr. João Gabriel"
                            required>
                        @error('name')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold text-slate-700 fs-13 mb-1">E-mail Profissional</label>
                        <input type="email"
                            class="form-control form-control-custom @error('email') is-invalid @enderror"
                            id="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="gestor@clinica.com"
                            required>
                        @error('email')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold text-slate-700 fs-13 mb-1">Senha de Acesso (mín. 6 caracteres)</label>
                        <input type="password"
                            class="form-control form-control-custom @error('password') is-invalid @enderror"
                            id="password" name="password"
                            placeholder="••••••••"
                            required>
                        @error('password')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- SEÇÃO 2: DADOS DA CLÍNICA -->
                <div class="section-label-chip"><i class="bi bi-building-fill"></i> 2. Informações da Clínica</div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Razão Social / Nome da Clínica</label>
                        <input type="text"
                            name="nome"
                            class="form-control form-control-custom @error('nome') is-invalid @enderror"
                            value="{{ old('nome') }}"
                            placeholder="Clínica Vida Saudável Ltda"
                            required>
                        @error('nome')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">CNPJ</label>
                        <input type="text"
                            name="cnpj"
                            class="form-control form-control-custom @error('cnpj') is-invalid @enderror"
                            value="{{ old('cnpj') }}"
                            placeholder="00.000.000/0001-00"
                            required>
                        @error('cnpj')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Telefone Principal (WhatsApp)</label>
                        <input type="text"
                            name="telefone"
                            class="form-control form-control-custom @error('telefone') is-invalid @enderror"
                            value="{{ old('telefone') }}"
                            placeholder="(11) 99999-9999"
                            required>
                        @error('telefone')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Endereço Completo</label>
                        <input type="text"
                            name="endereco"
                            class="form-control form-control-custom @error('endereco') is-invalid @enderror"
                            value="{{ old('endereco') }}"
                            placeholder="Av. Paulista, 1000 - Conjunto 501, São Paulo - SP"
                            required>
                        @error('endereco')
                            <div class="text-danger mt-1 fs-12 fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn-submit-auth mb-4">
                    <i class="bi bi-rocket-takeoff-fill me-2"></i> Finalizar Cadastro & Criar Ambiente
                </button>
            </form>

            <div class="text-center text-muted fs-14">
                Já possui uma clínica cadastrada? <a href="{{ route('login') }}" class="text-emerald-600 fw-bold text-decoration-none">Entrar no sistema</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>