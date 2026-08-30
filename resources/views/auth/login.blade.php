<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar na Plataforma — Vida Saudável</title>
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
            width: 45%;
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
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .banner-hero-text p {
            font-size: 15px;
            color: #94a3b8;
            line-height: 1.6;
            max-width: 380px;
        }

        .floating-feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .auth-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .auth-box-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .auth-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .form-control-custom {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
            padding: 12px 16px 12px 42px;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
            outline: none;
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
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
            <h1>Gestão clínica moderna e automação inteligente</h1>
            <p>Acesse seu painel com segurança e gerencie consultas, médicos e notificações em tempo real.</p>
        </div>

        <div class="floating-feature-card">
            <div class="bg-emerald-500 p-3 rounded-3 text-white fs-4 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <i class="bi bi-whatsapp"></i>
            </div>
            <div>
                <h6 class="fw-bold text-white mb-0">Confirmações via Z-API</h6>
                <small class="text-slate-300">Mensagens instantâneas para seus pacientes</small>
            </div>
        </div>
    </div>

    <!-- RIGHT FORM SIDE -->
    <div class="auth-form-side">
        <div class="auth-box-wrapper">
            <h2 class="auth-title">Bem-vindo de volta</h2>
            <p class="auth-subtitle">Insira suas credenciais para acessar sua conta</p>

            <form action="{{ route('auth-login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold text-slate-700 fs-14">E-mail Profissional</label>
                    <div class="input-icon-group">
                        <i class="bi bi-envelope-fill"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control form-control-custom @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="seu@clinica.com"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="text-danger mt-1 fs-12 fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-slate-700 fs-14">Senha de Acesso</label>
                    <div class="input-icon-group">
                        <i class="bi bi-lock-fill"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control form-control-custom @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                    @error('password')
                        <div class="text-danger mt-1 fs-12 fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit-auth mb-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Entrar na Plataforma
                </button>
            </form>

            <div class="text-center text-muted fs-14">
                Sua clínica ainda não tem conta? <a href="{{ route('register') }}" class="text-emerald-600 fw-bold text-decoration-none">Cadastre-se grátis</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>