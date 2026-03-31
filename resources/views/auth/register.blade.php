<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Conta — Vida Saudável</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --green: #16a34a; --green-dark: #166534; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            margin: 0;
        }

        .auth-panel-left {
            background: linear-gradient(160deg, #0f1f14 0%, #166534 55%, #16a34a 100%);
            width: 38%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 48px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .auth-panel-left::before {
            content: '';
            position: absolute;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
            top: -120px; right: -100px;
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark .icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .brand-mark .name { font-size: 17px; font-weight: 800; line-height: 1.1; }
        .brand-mark .tagline { font-size: 11px; opacity: .6; display: block; }

        .left-hero h1 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .left-hero p {
            font-size: 14px;
            opacity: .7;
            line-height: 1.6;
        }

        .step-list { list-style: none; padding: 0; margin: 0; }
        .step-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 13.5px;
            opacity: .85;
        }

        .step-list .dot {
            width: 22px; height: 22px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .auth-panel-right {
            flex: 1;
            overflow-y: auto;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 32px;
        }

        .auth-box {
            width: 100%;
            max-width: 520px;
            animation: fadeInUp .35s ease;
        }

        .auth-box h2 { font-size: 22px; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .auth-box .subtitle { font-size: 13px; color: #6b7280; margin-bottom: 24px; }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 16px;
        }

        .section-divider hr { flex: 1; margin: 0; border-color: #e5e7eb; }
        .section-divider span {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #9ca3af;
            white-space: nowrap;
        }

        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }

        .form-control {
            border-radius: 9px;
            border: 1.5px solid #e5e7eb;
            font-size: 13.5px;
            padding: 9px 13px;
            font-family: inherit;
            transition: border-color .18s, box-shadow .18s;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
            outline: none;
        }

        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: 12px; }

        .btn-auth {
            background: var(--green);
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-weight: 700;
            font-size: 14px;
            padding: 12px;
            color: #fff;
            width: 100%;
            cursor: pointer;
            transition: background .18s, transform .1s;
        }

        .btn-auth:hover { background: var(--green-dark); }
        .btn-auth:active { transform: scale(.98); }

        .auth-footer { text-align: center; margin-top: 16px; font-size: 13px; color: #6b7280; }
        .auth-footer a { color: var(--green); font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .auth-panel-left { display: none; }
            .auth-panel-right { padding: 24px 16px; }
        }
    </style>
</head>
<body>

<div class="auth-panel-left">
    <div class="brand-mark">
        <div class="icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <div>
            <div class="name">Vida Saudável</div>
            <span class="tagline">Sistema de Gestão Clínica</span>
        </div>
    </div>

    <div class="left-hero">
        <h1>Comece a gerenciar sua clínica hoje</h1>
        <p>Crie sua conta em minutos e tenha controle total da sua operação.</p>
    </div>

    <ul class="step-list">
        <li><div class="dot">1</div> Crie sua conta de administrador</li>
        <li><div class="dot">2</div> Cadastre as informações da clínica</li>
        <li><div class="dot">3</div> Adicione médicos e recepcionistas</li>
        <li><div class="dot">4</div> Comece a agendar consultas</li>
    </ul>
</div>

<div class="auth-panel-right">
    <div class="auth-box">
        <h2>Criar nova conta</h2>
        <p class="subtitle">Preencha os dados abaixo para começar</p>

        <form method="POST" action="{{ route('auth-register') }}">
            @csrf

            {{-- CONTA --}}
            <div class="section-divider">
                <hr><span><i class="bi bi-person me-1"></i>Dados da Conta</span><hr>
            </div>

            <div class="row g-3 mb-2">
                <div class="col-12">
                    <label for="name" class="form-label">Nome completo</label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name"
                        value="{{ old('name') }}"
                        placeholder="Seu nome"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="seu@email.com"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password" name="password"
                        placeholder="••••••••"
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CLÍNICA --}}
            <div class="section-divider">
                <hr><span><i class="bi bi-building me-1"></i>Dados da Clínica</span><hr>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nome da Clínica</label>
                    <input type="text"
                        name="nome"
                        class="form-control @error('nome') is-invalid @enderror"
                        value="{{ old('nome') }}"
                        placeholder="Ex: Clínica Saúde Total"
                        required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">CNPJ</label>
                    <input type="text"
                        name="cnpj"
                        class="form-control @error('cnpj') is-invalid @enderror"
                        value="{{ old('cnpj') }}"
                        placeholder="00.000.000/0001-00"
                        required>
                    @error('cnpj')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text"
                        name="telefone"
                        class="form-control @error('telefone') is-invalid @enderror"
                        value="{{ old('telefone') }}"
                        placeholder="(00) 00000-0000"
                        required>
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Endereço</label>
                    <input type="text"
                        name="endereco"
                        class="form-control @error('endereco') is-invalid @enderror"
                        value="{{ old('endereco') }}"
                        placeholder="Rua, número, bairro, cidade"
                        required>
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-auth mt-4">
                <i class="bi bi-check2-circle me-2"></i>Criar conta e continuar
            </button>

        </form>

        <div class="auth-footer">
            Já possui conta? <a href="{{ route('login') }}">Entrar</a>
        </div>
    </div>
</div>

</body>
</html>