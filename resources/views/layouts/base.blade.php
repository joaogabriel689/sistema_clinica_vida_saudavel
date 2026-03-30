<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clínica Vida Saudável</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" class="me-2">
            Clínica Vida Saudável
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard_split') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    
                    <a class="nav-link" href="{{ route('me') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg></a>
                </li>

            </ul>
        </div>
    </div>
</nav>

    {{-- Conteúdo dinâmico --}}
<main class="flex-fill">
    <div class="container py-4">
        @yield('content')
    </div>
</main>



<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <p class="mb-1">© 2026 Clínica Vida Saudável</p>
        <small>Cuidando da sua saúde com responsabilidade e dedicação.</small>
    </div>
    @if(auth()->check())
        <form action="{{ route('logout') }}" method="post" class="position-fixed bottom-0 end-0 m-4">
            @csrf
            <button type="submit" class="btn btn-danger">
                Sair
            </button>
        </form>
    @endif
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

</body>
</html>