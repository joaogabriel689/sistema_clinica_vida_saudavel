{{-- ========================
     login.blade.php
======================== --}}
{{-- NOTE: This file replaces the login page --}}
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar — Vida Saudável</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #16a34a;
            --green-dark: #166534;
        }
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
            width: 42%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
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

        .auth-panel-left::after {
            content: '';
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
            bottom: -60px; left: -60px;
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
            backdrop-filter: blur(4px);
        }

        .brand-mark .name {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.1;
        }

        .brand-mark .tagline {
            font-size: 11px;
            opacity: .6;
            display: block;
        }

        .left-hero { position: relative; z-index: 1; }
        .left-hero h1 {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .left-hero p {
            font-size: 14.5px;
            opacity: .7;
            line-height: 1.6;
            max-width: 320px;
        }

        .left-stats {
            display: flex;
            gap: 24px;
            position: relative;
            z-index: 1;
        }

        .left-stats .stat { }
        .left-stats .stat-value {
            font-size: 26px;
            font-weight: 800;
        }

        .left-stats .stat-label {
            font-size: 11.5px;
            opacity: .6;
            display: block;
        }

        .auth-panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
        }

        .auth-box {
            width: 100%;
            max-width: 400px;
        }

        .auth-box h2 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .auth-box .subtitle {
            font-size: 13.5px;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            font-size: 13.5px;
            padding: 10px 14px;
            font-family: inherit;
            transition: border-color .18s, box-shadow .18s;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
            outline: none;
        }

        .form-control.is-invalid { border-color: #ef4444; }

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

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }

        .auth-footer a { color: var(--green); font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        .input-group-icon {
            position: relative;
        }

        .input-group-icon .bi {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
        }

        .input-group-icon .form-control { padding-left: 38px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-box { animation: fadeInUp .35s ease; }

        @media (max-width: 768px) {
            .auth-panel-left { display: none; }
            .auth-panel-right { padding: 32px 20px; }
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
        <h1>Gestão clínica inteligente e eficiente</h1>
        <p>Controle consultas, médicos, convênios e finanças em um único sistema moderno.</p>
    </div>

    <div class="left-stats">
        <div class="stat">
            <div class="stat-value">100%</div>
            <span class="stat-label">Seguro</span>
        </div>
        <div class="stat">
            <div class="stat-value">24/7</div>
            <span class="stat-label">Disponível</span>
        </div>
        <div class="stat">
            <div class="stat-value">+500</div>
            <span class="stat-label">Consultas/mês</span>
        </div>
    </div>
</div>

<div class="auth-panel-right">
    <div class="auth-box">
        <h2>Bem-vindo de volta</h2>
        <p class="subtitle">Entre com suas credenciais para acessar o sistema</p>

        <form action="{{ route('auth-login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Endereço de email</label>
                <div class="input-group-icon">
                    <i class="bi bi-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="seu@email.com"
                        required
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback d-block mt-1" style="font-size:12px;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group-icon">
                    <i class="bi bi-lock"></i>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                    >
                </div>
                @error('password')
                    <div class="invalid-feedback d-block mt-1" style="font-size:12px;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar no sistema
            </button>

        </form>

        <div class="auth-footer">
            Não possui conta? <a href="{{ route('register') }}">Cadastrar agora</a>
        </div>
    </div>
</div>

</body>
</html>