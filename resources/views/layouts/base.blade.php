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
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ms-2" href="{{ route('register') }}">Registrar</a>
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
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>