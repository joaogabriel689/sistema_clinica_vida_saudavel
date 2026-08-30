@extends('layouts.base')

@section('title', 'Vida Saudável — Gestão Clínica Inteligente & Agendamento sem Faltas no WhatsApp')
@section('meta_description', 'Reduza o absenteísmo médico em até 80% com automação de lembretes no WhatsApp, página própria de agendamento online e prontuário seguro.')

@section('content')
<style>
    /* Hero Gradient & Mesh */
    .hero-saas {
        background: radial-gradient(100% 100% at 50% 0%, #064e3b 0%, #022c22 100%);
        border-radius: 28px;
        padding: 80px 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 48px -12px rgba(6, 78, 59, 0.35);
        margin-bottom: 56px;
    }

    .hero-saas::before {
        content: '';
        position: absolute;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(52, 211, 153, 0.15) 0%, rgba(0,0,0,0) 70%);
        top: -200px; right: -150px;
        pointer-events: none;
    }

    .pill-badge-hero {
        background: rgba(52, 211, 153, 0.15);
        border: 1px solid rgba(52, 211, 153, 0.3);
        color: #34d399;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 8px 20px;
        border-radius: 99px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 52px;
        font-weight: 800;
        line-height: 1.12;
        letter-spacing: -0.03em;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 19px;
        color: #cbd5e1;
        max-width: 720px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    /* Calculator Card */
    .calc-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 36px;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.08);
    }

    .calc-result-box {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid #a7f3d0;
        border-radius: 20px;
        padding: 28px;
        text-align: center;
    }

    /* Feature Card */
    .feature-card-saas {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 36px 30px;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .feature-card-saas:hover {
        transform: translateY(-6px);
        border-color: #10b981;
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.18);
    }

    .feature-icon-box {
        width: 60px; height: 60px;
        border-radius: 18px;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.15);
    }

    /* Pricing Section */
    .pricing-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 40px 32px;
        height: 100%;
        position: relative;
        transition: all 0.3s ease;
    }

    .pricing-card.featured {
        border: 2px solid #10b981;
        box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.2);
        background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    }

    .pricing-badge {
        position: absolute;
        top: -14px; right: 28px;
        background: linear-gradient(135deg, #10b981, #047857);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 99px;
        letter-spacing: 0.05em;
    }

    .price-value {
        font-size: 44px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 34px; }
        .hero-saas { padding: 48px 20px; }
    }
</style>

<!-- HERO SECTION -->
<div class="hero-saas text-center">
    <div class="pill-badge-hero">
        <i class="bi bi-shield-check"></i> Plataforma Inteligente de Gestão Clínica
    </div>
    <h1 class="hero-title">Gestão Clínica sem Faltas & Agendamento Automático no WhatsApp</h1>
    <p class="hero-subtitle">
        Elimine o absenteísmo de pacientes em até 80%, ofereça agendamento online 24h com a página própria da sua clínica e tenha total controle médico e financeiro.
    </p>

    <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
        <a href="{{ route('register') }}" class="btn btn-emerald btn-lg px-4 py-3 fs-6">
            <i class="bi bi-rocket-takeoff-fill me-2"></i> Criar Minha Clínica Grátis (14 Dias)
        </a>
        <a href="#calculadora" class="btn btn-outline-light btn-lg px-4 py-3 fs-6 fw-bold" style="border-radius: var(--radius-md);">
            <i class="bi bi-calculator me-2"></i> Calcular Minha Economia
        </a>
    </div>

    <!-- METRICS STRIP -->
    <div class="row g-4 mt-5 pt-3 justify-content-center border-top border-white border-opacity-10 text-start">
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-whatsapp fs-2 text-emerald-400"></i>
                <div>
                    <h5 class="fw-extrabold m-0">-80% Faltas</h5>
                    <small class="text-slate-300 fs-12">Confirmação no WhatsApp</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-globe fs-2 text-emerald-400"></i>
                <div>
                    <h5 class="fw-extrabold m-0">Link Próprio</h5>
                    <small class="text-slate-300 fs-12">Página Web da Clínica</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-shield-lock-fill fs-2 text-emerald-400"></i>
                <div>
                    <h5 class="fw-extrabold m-0">Segurança LGPD</h5>
                    <small class="text-slate-300 fs-12">Prontuário Criptografado</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CALCULADORA DE RETORNO / ECONOMIA -->
<div class="mb-5" id="calculadora">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <span class="text-emerald-600 fw-extrabold text-uppercase letter-spacing-1 fs-12">Calculadora de Impacto</span>
            <h2 class="fw-extrabold text-slate-900 mt-2 mb-3">Quanto a sua clínica deixa de faturar com faltas?</h2>
            <p class="text-muted fs-16 mb-4">
                Estudos mostram que até <strong>20% das consultas</strong> são perdidas por esquecimento dos pacientes. Veja quanto você pode economizar ativando os lembretes automáticos por WhatsApp da <strong>Vida Saudável</strong>.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="calc-card">
                <div class="mb-3">
                    <label class="form-label fw-bold d-flex justify-content-between">
                        <span>Consultas Mensais</span>
                        <span class="text-emerald-600 fw-extrabold" id="valConsultas">200 consultas</span>
                    </label>
                    <input type="range" class="form-range" id="rangeConsultas" min="20" max="1000" step="10" value="200">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold d-flex justify-content-between">
                        <span>Valor Médio da Consulta (R$)</span>
                        <span class="text-emerald-600 fw-extrabold" id="valPreco">R$ 200</span>
                    </label>
                    <input type="range" class="form-range" id="rangePreco" min="50" max="1000" step="10" value="200">
                </div>

                <div class="calc-result-box">
                    <small class="text-emerald-800 font-monospace text-uppercase fw-bold fs-12">Economia Estimada por Mês</small>
                    <h3 class="fw-extrabold text-emerald-900 display-6 my-2" id="valEconomia">R$ 6.400,00</h3>
                    <small class="text-emerald-700">Ao recuperar consultas que seriam canceladas por falta de aviso.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SOLUÇÕES DO PRODUTO -->
<div class="mb-5 py-4">
    <div class="text-center mb-5">
        <span class="text-emerald-600 fw-extrabold text-uppercase letter-spacing-1 fs-12">Recursos Práticos</span>
        <h2 class="fw-extrabold text-slate-900 mt-2">Tudo o que sua clínica precisa em uma só plataforma</h2>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-whatsapp"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Lembretes por WhatsApp</h4>
                <p class="text-muted mb-0">Disparo automático de lembretes 24h antes da consulta. O paciente confirma com apenas 1 clique e sua agenda se mantém cheia.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-globe2"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Página Web da Clínica</h4>
                <p class="text-muted mb-0">Sua clínica ganha uma página pública exclusiva com corpo médico, especialidades e agendamento online direto para seus pacientes.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-calendar2-check-fill"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Agenda Inteligente</h4>
                <p class="text-muted mb-0">Controle completo de horários por médico, evitando choque de consultas e organizando a recepção da clínica com facilidade.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-file-earmark-medical-fill"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Prontuário Eletrônico</h4>
                <p class="text-muted mb-0">Histórico de pacientes, anotações de consultas e registros organizados de forma centralizada e totalmente em conformidade com a LGPD.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-credit-card-2-front-fill"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Faturamento de Convênios</h4>
                <p class="text-muted mb-0">Cálculo de descontos por convênio em tempo real, registro de pagamentos e relatórios financeiros claros para o gestor.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-card-saas">
                <div class="feature-icon-box"><i class="bi bi-shield-check"></i></div>
                <h4 class="fw-bold text-slate-900 mb-2">Acesso por Perfis</h4>
                <p class="text-muted mb-0">Telas otimizadas para Administradores, Recepcionistas e Médicos. Cada profissional acessa exatamente o que precisa com total segurança.</p>
            </div>
        </div>
    </div>
</div>

<!-- PRICING SECTION -->
<div class="py-4 mb-5">
    <div class="text-center mb-5">
        <span class="text-emerald-600 fw-extrabold text-uppercase letter-spacing-1 fs-12">Planos Transparentes</span>
        <h2 class="fw-extrabold text-slate-900 mt-2">Escolha o plano ideal para a sua clínica</h2>
        <p class="text-muted">Sem fidelidade. Cancele quando quiser.</p>
    </div>

    <div class="row g-4 align-items-center">
        <!-- PLANO BASICO -->
        <div class="col-lg-4">
            <div class="pricing-card">
                <h4 class="fw-bold text-slate-900 mb-1">Starter</h4>
                <p class="text-muted fs-14 mb-4">Para consultórios individuais</p>
                <div class="d-flex align-items-baseline gap-1 mb-4">
                    <span class="price-value">R$ 149</span>
                    <span class="text-muted fw-semibold">/mês</span>
                </div>
                <ul class="list-unstyled mb-4 d-flex flex-column gap-3 text-slate-700 fs-14">
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> <strong>1 Médico</strong> cadastrado</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> <strong>1 Recepcionista</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Até 100 consultas/mês</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Lembretes WhatsApp inclusos</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Página pública da clínica</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-outline-dark w-100 fw-bold py-2" style="border-radius: var(--radius-md);">Assinar Starter</a>
            </div>
        </div>

        <!-- PLANO PRO -->
        <div class="col-lg-4">
            <div class="pricing-card featured">
                <div class="pricing-badge">Mais Escolhido</div>
                <h4 class="fw-bold text-slate-900 mb-1">Clínica Pro</h4>
                <p class="text-muted fs-14 mb-4">Para clínicas em crescimento</p>
                <div class="d-flex align-items-baseline gap-1 mb-4">
                    <span class="price-value">R$ 299</span>
                    <span class="text-muted fw-semibold">/mês</span>
                </div>
                <ul class="list-unstyled mb-4 d-flex flex-column gap-3 text-slate-700 fs-14">
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Até <strong>5 Médicos</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> <strong>3 Recepcionistas</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Consultas <strong>Ilimitadas</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Lembretes WhatsApp ilimitados</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Página pública com agendamento</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Suporte prioritário</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-emerald w-100 py-3 fs-6">Começar 14 Dias Grátis</a>
            </div>
        </div>

        <!-- PLANO ENTERPRISE -->
        <div class="col-lg-4">
            <div class="pricing-card">
                <h4 class="fw-bold text-slate-900 mb-1">Enterprise</h4>
                <p class="text-muted fs-14 mb-4">Para redes e centros médicos</p>
                <div class="d-flex align-items-baseline gap-1 mb-4">
                    <span class="price-value">R$ 599</span>
                    <span class="text-muted fw-semibold">/mês</span>
                </div>
                <ul class="list-unstyled mb-4 d-flex flex-column gap-3 text-slate-700 fs-14">
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Médicos <strong>Ilimitados</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Recepcionistas <strong>Ilimitadas</strong></li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Domínio personalizado da clínica</li>
                    <li><i class="bi bi-check-circle-fill text-emerald-500 me-2"></i> Relatórios avançados e API</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-outline-dark w-100 fw-bold py-2" style="border-radius: var(--radius-md);">Contatar Vendas</a>
            </div>
        </div>
    </div>
</div>

<!-- FAQ INTERATIVO -->
<div class="mb-5 py-4">
    <div class="text-center mb-5">
        <span class="text-emerald-600 fw-extrabold text-uppercase letter-spacing-1 fs-12">Dúvidas Frequentes</span>
        <h2 class="fw-extrabold text-slate-900 mt-2">Perguntas comuns dos nossos clientes</h2>
    </div>

    <div class="accordion accordion-flush mx-auto" id="faqAccordion" style="max-width: 800px;">
        <div class="accordion-item border rounded-3 mb-3 shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button fw-bold text-slate-900 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                    Preciso instalar algum programa no computador da clínica?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-muted">
                    Não! A <strong>Vida Saudável</strong> funciona 100% na nuvem. Você e sua equipe podem acessar de qualquer computador, notebook, tablet ou smartphone com acesso à internet.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 mb-3 shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold text-slate-900 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    Como funciona a confirmação de consultas no WhatsApp?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-muted">
                    O sistema dispara mensagens automáticas para os pacientes lembrando do dia e horário da consulta. O paciente responde confirmando ou solicitando remarcação e o status na sua agenda atualiza instantaneamente.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 mb-3 shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold text-slate-900 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                    Minha clínica terá um link próprio para agendamento online?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-muted">
                    Sim! Ao cadastrar sua clínica, fornecemos um link personalizado exclusivo (ex: <code>vidasaudavel.com/c/suaclinica</code>) para você colocar na bio do Instagram, site ou enviar para pacientes agendarem sozinhos.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rangeC = document.getElementById('rangeConsultas');
    const rangeP = document.getElementById('rangePreco');
    const valC = document.getElementById('valConsultas');
    const valP = document.getElementById('valPreco');
    const valE = document.getElementById('valEconomia');

    function calcular() {
        const consultas = parseInt(rangeC.value);
        const preco = parseFloat(rangeP.value);
        
        valC.textContent = consultas + ' consultas';
        valP.textContent = 'R$ ' + preco.toLocaleString('pt-BR');

        // Faltas estimadas (20%) e recuperação de 80% das faltas
        const faltas = consultas * 0.20;
        const recuperadas = faltas * 0.80;
        const economia = recuperadas * preco;

        valE.textContent = 'R$ ' + economia.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    rangeC.addEventListener('input', calcular);
    rangeP.addEventListener('input', calcular);
    calcular();
});
</script>
@endsection