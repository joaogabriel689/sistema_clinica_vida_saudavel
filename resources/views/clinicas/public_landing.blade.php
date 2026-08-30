<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $clinica->nome }} — Atendimento & Contato</title>
    <meta name="description" content="{{ $clinica->descricao ?? 'Entre em contato diretamente com a recepção e equipe da ' . $clinica->nome . ' via WhatsApp.' }}">
    
    <!-- OpenGraph SEO -->
    <meta property="og:title" content="{{ $clinica->nome }} — Central de Atendimento">
    <meta property="og:description" content="Fale diretamente com os nossos recepcionistas via WhatsApp e tire suas dúvidas.">
    <meta property="og:type" content="website">

    <!-- Fonts & Bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brand-primary: {{ $clinica->cor_primaria ?? '#059669' }};
            --brand-dark: {{ $clinica->cor_primaria ? $clinica->cor_primaria : '#064e3b' }};
            --brand-light: #f0fdf4;
            --slate-900: #0f172a;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-100: #f1f5f9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--slate-900);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 0;
        }

        .hero-public {
            background: linear-gradient(135deg, var(--brand-primary), #0f172a);
            color: #ffffff;
            padding: 60px 0 50px;
            border-radius: 0 0 32px 32px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.25);
            position: relative;
            overflow: hidden;
        }

        @if($clinica->banner_url)
        .hero-public::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('{{ $clinica->banner_url }}') center/cover no-repeat;
            opacity: 0.25;
            filter: blur(2px);
        }
        @endif

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .clinic-logo-img {
            max-height: 80px;
            max-width: 220px;
            object-fit: contain;
            border-radius: 12px;
            background: #ffffff;
            padding: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card-recepcionista {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-recepcionista:hover {
            transform: translateY(-5px);
            border-color: var(--brand-primary);
            box-shadow: 0 16px 32px -10px rgba(5, 150, 105, 0.2);
        }

        .recep-avatar {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--brand-light);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            border: 2px solid var(--brand-primary);
        }

        .btn-whatsapp {
            background-color: #25d366;
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-whatsapp:hover {
            background-color: #1eb954;
            color: #ffffff;
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
        }

        .info-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .footer-public {
            background: var(--slate-900);
            color: #94a3b8;
            padding: 30px 0 20px;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- TOP NAV -->
    <header class="header-nav sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                @if($clinica->logo_url)
                    <img src="{{ $clinica->logo_url }}" alt="{{ $clinica->nome }}" class="clinic-logo-img" style="max-height: 48px; padding: 4px;">
                @else
                    <div class="recep-avatar" style="width: 44px; height: 44px; font-size: 20px;">
                        <i class="bi bi-hospital"></i>
                    </div>
                @endif
                <div>
                    <h5 class="m-0 fw-extrabold text-slate-900">{{ $clinica->nome }}</h5>
                    <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $clinica->endereco ?? 'Atendimento Presencial' }}</small>
                </div>
            </div>

            @php
                $cleanPhoneMain = preg_replace('/\D/', '', $clinica->telefone ?? '');
                if (strlen($cleanPhoneMain) > 0 && !str_starts_with($cleanPhoneMain, '55')) {
                    $cleanPhoneMain = '55' . $cleanPhoneMain;
                }
            @endphp

            @if($cleanPhoneMain)
                <a href="https://wa.me/{{ $cleanPhoneMain }}?text={{ urlencode('Olá! Gostaria de mais informações sobre o atendimento da ' . $clinica->nome) }}" 
                   target="_blank" 
                   class="btn btn-whatsapp btn-sm style-header-btn" style="width: auto; padding: 8px 18px;">
                    <i class="bi bi-whatsapp"></i> Falar no WhatsApp
                </a>
            @endif
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero-public text-center">
        <div class="container hero-content">
            @if($clinica->logo_url)
                <div class="mb-3">
                    <img src="{{ $clinica->logo_url }}" alt="{{ $clinica->nome }}" class="clinic-logo-img">
                </div>
            @endif

            <h1 class="fw-extrabold display-5 mb-3">{{ $clinica->nome }}</h1>
            
            <p class="fs-5 text-slate-200 mx-auto mb-4" style="max-width: 680px;">
                {{ $clinica->descricao ?? 'Seja bem-vindo(a)! Nossa equipe de atendimento está à disposição para ajudar você a agendar consultas e tirar dúvidas.' }}
            </p>

            <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 border border-white border-opacity-25 text-white px-4 py-2 rounded-pill fs-14">
                <i class="bi bi-geo-alt-fill text-emerald-400"></i> {{ $clinica->endereco ?? 'Endereço Principal' }}
                <span class="mx-2">•</span>
                <i class="bi bi-telephone-fill text-emerald-400"></i> {{ $clinica->telefone ?? 'Contato Oficial' }}
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="container my-5">

        <!-- INFORMAÇÕES DA CLÍNICA & CENTRAL DE ATENDIMENTO -->
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-10">
                
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div>
                        <span class="text-uppercase fw-bold fs-12 letter-spacing-1" style="color: var(--brand-primary);">Central de Atendimento</span>
                        <h3 class="fw-extrabold text-slate-900 mt-1 mb-0">Recepcionistas & Atendentes</h3>
                    </div>
                    <div>
                        <span class="badge bg-emerald-100 text-emerald-800 px-3 py-2 fs-13 rounded-pill" style="background:#d1fae5; color:#065f46;">
                            <i class="bi bi-chat-dots-fill me-1"></i> Resposta Rápida via WhatsApp
                        </span>
                    </div>
                </div>

                @if($recepcionistas->isEmpty())
                    <div class="info-box text-center py-5">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <h5 class="fw-bold mt-3 text-slate-900">Contato Direto da Clínica</h5>
                        <p class="text-muted mb-4">Abaixo está o telefone oficial da nossa recepção para atendimento imediato:</p>
                        
                        @if($cleanPhoneMain)
                            <div class="d-inline-block" style="max-width: 320px;">
                                <a href="https://wa.me/{{ $cleanPhoneMain }}?text={{ urlencode('Olá! Gostaria de atendimento com a recepção da ' . $clinica->nome) }}" 
                                   target="_blank" class="btn-whatsapp py-3">
                                    <i class="bi bi-whatsapp fs-5"></i> Falar com a Recepção ({{ $clinica->telefone }})
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($recepcionistas as $recepcionista)
                            @php
                                $recPhone = preg_replace('/\D/', '', $recepcionista->telefone ?? $clinica->telefone ?? '');
                                if (strlen($recPhone) > 0 && !str_starts_with($recPhone, '55')) {
                                    $recPhone = '55' . $recPhone;
                                }
                                $displayPhone = $recepcionista->telefone ?? $clinica->telefone ?? 'Contato Oficial';
                            @endphp

                            <div class="col-md-6 col-lg-4">
                                <div class="card-recepcionista">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="recep-avatar">
                                                {{ strtoupper(substr($recepcionista->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold m-0 text-slate-900 fs-16">{{ $recepcionista->name }}</h6>
                                                <span class="badge bg-slate-100 text-slate-700 fs-12 fw-semibold mt-1">
                                                    Recepcionista
                                                </span>
                                            </div>
                                        </div>

                                        <div class="text-slate-600 fs-14 mb-4">
                                            <div class="mb-1"><i class="bi bi-telephone-fill me-2 text-emerald-600"></i>{{ $displayPhone }}</div>
                                            <div><i class="bi bi-envelope me-2 text-slate-400"></i>{{ $recepcionista->email }}</div>
                                        </div>
                                    </div>

                                    @if($recPhone)
                                        <a href="https://wa.me/{{ $recPhone }}?text={{ urlencode('Olá ' . $recepcionista->name . '! Gostaria de atendimento para a clínica ' . $clinica->nome) }}" 
                                           target="_blank" class="btn-whatsapp">
                                            <i class="bi bi-whatsapp fs-5"></i> Conversar no WhatsApp
                                        </a>
                                    @else
                                        <button disabled class="btn btn-secondary w-100 py-2 fs-14" style="border-radius:12px;">
                                            Telefone não informado
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- DETALHES ADICIONAIS DA CLÍNICA -->
                <div class="info-box mt-5">
                    <h5 class="fw-bold text-slate-900 mb-3"><i class="bi bi-info-circle-fill me-2" style="color: var(--brand-primary);"></i>Informações da Unidade</h5>
                    <div class="row g-3 fs-14 text-slate-700">
                        <div class="col-md-6">
                            <strong><i class="bi bi-building me-1"></i> Razão / Nome:</strong> {{ $clinica->nome }}
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-card-heading me-1"></i> CNPJ:</strong> {{ $clinica->cnpj ?? 'Não informado' }}
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-geo-alt me-1"></i> Endereço:</strong> {{ $clinica->endereco ?? 'Não informado' }}
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-telephone me-1"></i> Telefone Principal:</strong> {{ $clinica->telefone ?? 'Não informado' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="footer-public text-center">
        <div class="container">
            <h6 class="fw-bold text-white mb-1">{{ $clinica->nome }}</h6>
            <p class="fs-13 text-slate-400 mb-2">{{ $clinica->endereco ?? 'Atendimento médico humanizado' }} • CNPJ: {{ $clinica->cnpj ?? 'N/A' }}</p>
            <div class="border-top border-secondary border-opacity-25 pt-2 fs-12 text-slate-500">
                © {{ date('Y') }} {{ $clinica->nome }} • Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
