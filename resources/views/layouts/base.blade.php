<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Vida Saudável — Gestão Clínica Inteligente & Automação WhatsApp')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Plataforma completa de Gestão Clínica: Agendamento sem Faltas, Lembretes Automáticos via WhatsApp, Prontuário Eletrônico e Faturamento de Convênios.')">
    <meta name="keywords" content="gestão clínica, sistema para médicos, agendamento de consultas online, lembrete whatsapp consulta, prontuário eletrônico médico, software médico">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OpenGraph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Vida Saudável — Gestão Clínica Inteligente')">
    <meta property="og:description" content="Reduza o absenteísmo médico em até 80% com confirmações automáticas por WhatsApp e agendamento online inteligente.">
    <meta property="og:site_name" content="Vida Saudável">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Vida Saudável — Gestão Clínica Inteligente')">
    <meta name="twitter:description" content="Reduza o absenteísmo médico em até 80% com confirmações automáticas por WhatsApp.">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "SoftwareApplication",
      "name": "Vida Saudável",
      "operatingSystem": "Web Browser",
      "applicationCategory": "HealthApplication",
      "offers": {
        "@@type": "Offer",
        "price": "149.00",
        "priceCurrency": "BRL"
      },
      "description": "Sistema de gestão de clínicas e consultórios médicos com automação de lembretes via WhatsApp e agendamento online."
    }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --emerald-50:  #ecfdf5;
            --emerald-100: #d1fae5;
            --emerald-400: #34d399;
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --emerald-700: #047857;
            --emerald-900: #064e3b;
            --obsidian-dark: #061610;
            --obsidian-card: #0c241a;
            
            --bg-body:      #f8fafc;
            --sidebar-w:    270px;
            --text-main:    #0f172a;
            --text-muted:   #64748b;
            --border-color: #e2e8f0;
            --card-shadow:  0 10px 30px -10px rgba(15, 23, 42, 0.05), 0 4px 12px -4px rgba(15, 23, 42, 0.03);
            --radius-lg:    16px;
            --radius-md:    12px;
            --radius-sm:    8px;
            --ease-spring:  cubic-bezier(0.16, 1, 0.3, 1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            margin: 0;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ─────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, var(--obsidian-dark) 0%, #092017 100%);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            transition: transform 0.3s var(--ease-spring);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
        }

        .sidebar-brand {
            padding: 24px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--emerald-500), var(--emerald-700));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            flex-shrink: 0;
        }

        .brand-text span {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
            display: block;
            line-height: 1.1;
        }

        .brand-text small {
            font-size: 11px;
            color: var(--emerald-400);
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .tenant-badge {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            margin: 16px 16px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tenant-badge .tenant-name {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .tenant-badge .status-dot {
            width: 8px; height: 8px;
            background: var(--emerald-400);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--emerald-400);
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            padding: 20px 22px 6px;
        }

        .sidebar-nav {
            padding: 8px 14px;
            flex: 1;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-md);
            color: rgba(255, 255, 255, 0.65);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            text-decoration: none;
            position: relative;
        }

        .sidebar-nav .nav-link i {
            font-size: 18px;
            width: 22px;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .sidebar-nav .nav-link:hover i {
            color: var(--emerald-400);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--emerald-600), var(--emerald-700));
            color: #fff;
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.3);
        }

        .sidebar-nav .nav-link.active i {
            color: #fff;
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-md);
            color: #f87171;
            background: rgba(239, 68, 68, 0.08);
            font-size: 13.5px;
            font-weight: 700;
            width: 100%;
            border: 1px solid rgba(239, 68, 68, 0.15);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            transform: translateY(-1px);
        }

        /* ── MAIN WRAPPER ─────────────────────── */
        #main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ───────────────────────────── */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title-box h5 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 8px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 99px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .user-pill:hover {
            border-color: var(--emerald-500);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--emerald-500), var(--emerald-700));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
        }

        .user-info {
            line-height: 1.1;
        }

        .user-info .name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            display: block;
        }

        .user-info .role {
            font-size: 10.5px;
            color: var(--emerald-600);
            font-weight: 700;
            text-transform: uppercase;
        }

        /* ── PAGE CONTENT ─────────────────────── */
        .page-content {
            padding: 32px;
            flex: 1;
        }

        /* ── CARDS & UTILITIES ───────────────── */
        .card-custom {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            transition: all 0.25s var(--ease-spring);
        }

        .card-custom:hover {
            box-shadow: 0 16px 36px -12px rgba(15, 23, 42, 0.08);
        }

        .stat-card-modern {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.25s var(--ease-spring);
        }

        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, var(--emerald-500), var(--emerald-400));
        }

        .stat-card-modern:hover {
            transform: translateY(-4px);
            border-color: var(--emerald-400);
            box-shadow: 0 16px 32px -10px rgba(16, 185, 129, 0.15);
        }

        .stat-icon-wrapper {
            width: 48px; height: 48px;
            border-radius: var(--radius-md);
            background: var(--emerald-50);
            color: var(--emerald-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .btn-emerald {
            background: linear-gradient(135deg, var(--emerald-500), var(--emerald-600));
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 22px;
            border-radius: var(--radius-md);
            border: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-emerald:hover {
            background: linear-gradient(135deg, var(--emerald-600), var(--emerald-700));
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        /* ── ANIMATIONS ───────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up {
            animation: fadeInUp 0.4s var(--ease-spring) forwards;
        }

        /* ── MOBILE RESPONSIVE ────────────────── */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-wrapper { margin-left: 0; }
            .page-content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(4px);
                z-index: 1039;
                display: none;
            }

            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('index') }}" class="brand-box">
            <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
            <div class="brand-text">
                <span>Vida Saudável</span>
                <small>Gestão Clínica</small>
            </div>
        </a>
    </div>

    @if(auth()->check() && optional(auth()->user()->clinica)->nome)
    <div class="tenant-badge">
        <div>
            <div class="tenant-name"><i class="bi bi-building me-1"></i> {{ auth()->user()->clinica->nome }}</div>
        </div>
        <div class="status-dot" title="Clínica Ativa"></div>
    </div>
    @endif

    <nav class="sidebar-nav">
        @if(auth()->check())
        @if(auth()->user()->role === 'superadmin')
        <div class="sidebar-section-label text-purple-300"><i class="bi bi-shield-lock me-1"></i> SuperAdmin SaaS</div>
        <a href="{{ route('superadmin.dashboard') }}" class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 text-purple-400"></i> Dashboard MRR/ARR
        </a>
        <a href="{{ route('superadmin.clinicas') }}" class="nav-link {{ request()->routeIs('superadmin.clinicas*') ? 'active' : '' }}">
            <i class="bi bi-buildings text-purple-400"></i> Gestão de Clínicas
        </a>
        <a href="{{ route('superadmin.planos') }}" class="nav-link {{ request()->routeIs('superadmin.planos*') ? 'active' : '' }}">
            <i class="bi bi-tags text-purple-400"></i> Planos & Preços
        </a>
        @endif

        <div class="sidebar-section-label">Visão Geral</div>

        <a href="{{ route('dashboard_split') }}" class="nav-link {{ request()->routeIs('dashboard_split') || request()->routeIs('admin.index') || request()->routeIs('medicos.dashboard') || request()->routeIs('recepcionista.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Painel Principal
        </a>

        <div class="sidebar-section-label">Gestão de Atendimento</div>
            @if(auth()->user()->role == 'medico')
                <a href="{{ route('medicos.dashboard') }}" class="nav-link {{ request()->routeIs('medicos.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-calendar2-check-fill"></i> Minhas Consultas
                </a>
            @elseif(auth()->user()->role == 'admin')
                <a href="{{ route('admin.medicos') }}" class="nav-link {{ request()->routeIs('admin.medicos*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Corpo Médico
                </a>

                <a href="{{ route('admin.recepcionistas') }}" class="nav-link {{ request()->routeIs('admin.recepcionistas*') ? 'active' : '' }}">
                    <i class="bi bi-person-workspace"></i> Recepcionistas
                </a>

                <a href="{{ route('admin.convenios.index') }}" class="nav-link {{ request()->routeIs('admin.convenios*') ? 'active' : '' }}">
                    <i class="bi bi-shield-check"></i> Convênios Aceitos
                </a>
            @elseif(auth()->user()->role == 'recepcionista')
                <a href="{{ route('consultas.list') }}" class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar2-event-fill"></i> Agenda de Consultas
                </a>

                <a href="{{ route('admin.pacientes') }}" class="nav-link {{ request()->routeIs('admin.pacientes*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Pacientes
                </a>
            @endif

        <div class="sidebar-section-label">Automações & Financeiro</div>
        <a href="{{ route('whatsapp.index') }}" class="nav-link {{ request()->routeIs('whatsapp.*') ? 'active' : '' }}">
            <i class="bi bi-whatsapp"></i> WhatsApp & Notificações
        </a>
        <a href="{{ route('billing.index') }}" class="nav-link {{ request()->routeIs('billing.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-2-front-fill"></i> Plano da Clínica
        </a>

        @if(optional(auth()->user()->clinica)->slug)
        <a href="{{ route('clinica.public', auth()->user()->clinica->slug) }}" target="_blank" class="nav-link text-emerald-400">
            <i class="bi bi-globe me-2"></i> Minha Página Pública <i class="bi bi-box-arrow-up-right fs-12 ms-auto"></i>
        </a>
        @endif

        <div class="sidebar-section-label">Minha Conta</div>
        <a href="{{ route('me') }}" class="nav-link {{ request()->routeIs('me') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Perfil do Usuário
        </a>
        @else
        <div class="sidebar-section-label">Navegação</div>
        <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> Início
        </a>
        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i> Entrar na Plataforma
        </a>
        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
            <i class="bi bi-rocket-takeoff-fill"></i> Cadastrar Clínica
        </a>
        @endif
    </nav>

    @if(auth()->check())
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Encerrar Sessão
            </button>
        </form>
    </div>
    @endif
</aside>

<!-- MAIN -->
<div id="main-wrapper">
    <!-- TOPBAR -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none p-0 border-0 text-dark" onclick="toggleSidebar()">
                <i class="bi bi-list" style="font-size:26px;"></i>
            </button>
            <div class="topbar-title-box">
                <h5>@yield('title', 'Dashboard Geral')</h5>
            </div>
        </div>
        <div class="topbar-right">
            @if(auth()->check())
            <a href="{{ route('me') }}" class="user-pill">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info d-none d-sm-block">
                    <span class="name">{{ auth()->user()->name }}</span>
                    <span class="role">{{ auth()->user()->role }}</span>
                </div>
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark fw-bold px-3 me-2" style="border-radius: var(--radius-md);">Entrar</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-emerald fw-bold">Testar Grátis</a>
            @endif
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="page-content animate-fade-up">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center gap-2" style="border-radius: var(--radius-md); background: #d1fae5; color: #065f46;">
                <i class="bi bi-check-circle-fill text-emerald-600 fs-5"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center gap-2" style="border-radius: var(--radius-md);">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div class="fw-semibold">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>

</body>
</html>