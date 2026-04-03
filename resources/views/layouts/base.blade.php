<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Clínica Vida Saudável')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-primary: #16a34a;
            --green-dark:    #166534;
            --green-light:   #bbf7d0;
            --green-xlight:  #f0fdf4;
            --bg:            #f4f6f9;
            --sidebar-bg:    #0f1f14;
            --sidebar-width: 260px;
            --text-muted:    #6b7280;
            --text-main:     #111827;
            --card-shadow:   0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.07);
            --radius:        14px;
            --transition:    .18s ease;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ─────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            transition: transform var(--transition);
        }

        .sidebar-brand {
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: var(--green-primary);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-brand span {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-brand small {
            font-size: 11px;
            color: rgba(255,255,255,.4);
            display: block;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 18px 22px 6px;
        }

        .sidebar-nav {
            padding: 8px 12px;
            flex: 1;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            color: rgba(255,255,255,.55);
            font-size: 13.5px;
            font-weight: 500;
            transition: all var(--transition);
            margin-bottom: 2px;
            text-decoration: none;
        }

        .sidebar-nav .nav-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--green-primary);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .sidebar-footer .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            color: rgba(255,255,255,.5);
            font-size: 13.5px;
            font-weight: 500;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            text-align: left;
        }

        .sidebar-footer .logout-btn:hover {
            background: rgba(239,68,68,.15);
            color: #f87171;
        }

        /* ── MAIN CONTENT ─────────────────────── */
        #main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ───────────────────────────── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8ecf0;
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-main);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-avatar {
            width: 34px; height: 34px;
            background: var(--green-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--green-dark);
            cursor: pointer;
            border: 2px solid var(--green-primary);
        }

        /* ── PAGE CONTENT ─────────────────────── */
        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ── CARDS ────────────────────────────── */
        .card {
            border: 1px solid #e8ecf0;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            background: #fff;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f3f7;
            padding: 16px 20px;
            font-weight: 600;
            font-size: 14px;
        }

        /* ── METRIC CARDS ─────────────────────── */
        .metric-card {
            border-radius: var(--radius);
            padding: 22px;
            background: #fff;
            border: 1px solid #e8ecf0;
            box-shadow: var(--card-shadow);
            transition: transform .2s ease, box-shadow .2s ease;
            cursor: default;
            overflow: hidden;
            position: relative;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            right: 0; height: 3px;
            background: var(--accent, var(--green-primary));
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0,0,0,.10);
        }

        .metric-card .metric-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .metric-card .metric-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            margin-bottom: 4px;
        }

        .metric-card .metric-label {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .metric-card .metric-link {
            font-size: 12px;
            font-weight: 600;
            color: var(--green-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 12px;
        }

        .metric-card .metric-link:hover { text-decoration: underline; }

        /* ── BUTTONS ──────────────────────────── */
        .btn-primary {
            background: var(--green-primary);
            border-color: var(--green-primary);
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 9px;
            padding: 8px 18px;
            transition: all var(--transition);
        }

        .btn-primary:hover {
            background: var(--green-dark);
            border-color: var(--green-dark);
        }

        .btn-outline-primary {
            border-color: var(--green-primary);
            color: var(--green-primary);
            font-weight: 600;
            font-size: 13px;
            border-radius: 9px;
        }

        .btn-outline-primary:hover {
            background: var(--green-primary);
            border-color: var(--green-primary);
        }

        .btn-secondary {
            background: #f3f4f6;
            border-color: #e5e7eb;
            color: #374151;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 9px;
            padding: 8px 18px;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            border-color: #d1d5db;
            color: #111827;
        }

        /* ── FORMS ────────────────────────────── */
        .form-control, .form-select {
            border-radius: 9px;
            border: 1.5px solid #e5e7eb;
            font-size: 13.5px;
            padding: 9px 13px;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--green-primary);
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* ── TABLES ───────────────────────────── */
        .table thead th {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            background: #f9fafb;
            border-bottom: 2px solid #e8ecf0;
            padding: 11px 14px;
            white-space: nowrap;
        }

        .table tbody td {
            font-size: 13.5px;
            padding: 13px 14px;
            color: #374151;
            border-bottom: 1px solid #f0f3f7;
            vertical-align: middle;
        }

        .table tbody tr:hover td { background: #fafbfc; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── BADGES ───────────────────────────── */
        .badge {
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            padding: 4px 8px;
        }

        /* ── PAGE HEADER ──────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .page-header p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        /* ── ALERT ────────────────────────────── */
        .alert {
            border-radius: var(--radius);
            border: none;
            font-size: 13.5px;
            font-weight: 500;
        }

        .alert-success {
            background: var(--green-xlight);
            color: var(--green-dark);
            border-left: 4px solid var(--green-primary);
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* ── PAGINATION ───────────────────────── */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: 1.5px solid #e5e7eb;
            color: var(--green-primary);
            font-size: 13px;
            font-weight: 600;
        }

        .pagination .page-item.active .page-link {
            background: var(--green-primary);
            border-color: var(--green-primary);
        }

        /* ── ANIMATIONS ───────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in { animation: fadeInUp .35s ease both; }
        .fade-in-1 { animation-delay: .05s; }
        .fade-in-2 { animation-delay: .10s; }
        .fade-in-3 { animation-delay: .15s; }
        .fade-in-4 { animation-delay: .20s; }
        .fade-in-5 { animation-delay: .25s; }

        /* ── MOBILE ───────────────────────────── */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-wrapper { margin-left: 0; }
            .page-content { padding: 20px 16px; }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 1039;
                display: none;
            }

            .sidebar-overlay.show { display: block; }
        }

        /* ── SCROLLBAR ────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 99px; }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside id="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-2">
        <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <div>
            <span>Vida Saudável</span>
            <small>Sistema de Gestão</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        @if(auth()->check())
        <div class="sidebar-section-label">Geral</div>



        <a href="{{ route('dashboard_split') }}" class="nav-link {{ request()->routeIs('dashboard_split') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Meu Painel
        </a>

        <div class="sidebar-section-label">Operacional</div>
            @if(auth()->user()->role == 'medico')
             <a href="#" class="nav-link {{ request()->routeIs('consultas.minhas') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check"></i> Minhas Consultas
            </a>
            @elseif (auth()->user()->role == 'admin')

                    <a href="{{ route('admin.medicos') }}" class="nav-link {{ request()->routeIs('admin.medicos*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Médicos
                    </a>

                    <a href="{{ route('admin.recepcionistas') }}" class="nav-link {{ request()->routeIs('admin.recepcionistas*') ? 'active' : '' }}">
                        <i class="bi bi-person-workspace"></i> Recepcionistas
                    </a>

                    <a href="{{ route('admin.convenios.index') }}" class="nav-link {{ request()->routeIs('admin.convenios*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check"></i> Convênios
                    </a>
            @elseif(auth()->user()->role == 'recepcionista')
                    <a href="{{ route('admin.pacientes') }}" class="nav-link {{ request()->routeIs('admin.pacientes*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Médicos
                    </a>

                    <a href="{{ route('consultas.list') }}" class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}">
                        <i class="bi bi-person-workspace"></i> Recepcionistas
                    </a>



        <a href="{{ route('consultas.list') }}" class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}">
            <i class="bi bi-calendar2-check"></i> Consultas
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-people"></i> Pacientes
        </a>
        @endif



        <div class="sidebar-section-label">Conta</div>

        <a href="{{ route('me') }}" class="nav-link {{ request()->routeIs('me') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Meu Perfil
        </a>
        @else
        <div class="sidebar-section-label">Bem-vindo</div>
        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i> Entrar
        </a>
        @endif
    </nav>

    @if(auth()->check())
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Sair da conta
            </button>
        </form>
    </div>
    @endif
</aside>

<!-- MAIN -->
<div id="main-wrapper">
    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn btn-sm d-lg-none" onclick="toggleSidebar()" style="background:none;border:none;padding:4px;">
                <i class="bi bi-list" style="font-size:22px;"></i>
            </button>
            <h6 class="topbar-title">@yield('title', 'Dashboard')</h6>
        </div>
        <div class="topbar-right">
            @if(auth()->check())
            <a href="{{ route('me') }}" class="topbar-avatar" title="{{ auth()->user()->name }}">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </a>
            @endif
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success mb-4 fade-in">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>

</body>
</html>