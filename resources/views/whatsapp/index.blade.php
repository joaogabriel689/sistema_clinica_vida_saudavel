@extends('layouts.base')

@section('title', 'WhatsApp — Automação de Lembretes da Clínica')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-extrabold text-slate-900 m-0" style="letter-spacing: -0.02em;">Conexão com WhatsApp</h3>
        <p class="text-muted fs-14 m-0">Conecte o celular da sua clínica para envio automático de confirmações e lembretes aos pacientes</p>
    </div>
    
    <div>
        @if($instancia && $instancia->status === 'conectado')
            <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-2 fs-13 fw-bold">
                <i class="bi bi-patch-check-fill text-emerald-600 me-1"></i> WhatsApp Conectado
            </span>
        @elseif($instancia && $instancia->status === 'aguardando_qr')
            <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 px-3 py-2 fs-13 fw-bold">
                <i class="bi bi-qr-code-scan me-1"></i> Aguardando Leitura do QR Code
            </span>
        @else
            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 fs-13 fw-bold">
                <i class="bi bi-x-circle-fill me-1"></i> Desconectado
            </span>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- QR CODE & CONNECTION PANEL -->
    <div class="col-lg-5">
        <div class="card-custom p-4 text-center h-100 d-flex flex-column align-items-center justify-content-between">
            @if($instancia && $instancia->status === 'conectado')
                <div class="my-auto">
                    <div class="bg-emerald-50 rounded-circle p-4 mb-3 d-inline-flex align-items-center justify-content-center text-emerald-600 fs-1 shadow-sm" style="width:96px;height:96px;">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <h4 class="fw-bold text-slate-900 mb-1">WhatsApp Ativo & Sincronizado</h4>
                    <p class="text-muted fs-14 mb-4" style="max-width:320px;">Sua clínica está pronta para enviar lembretes e solicitações de confirmação aos pacientes automaticamente.</p>
                </div>

                <div class="d-flex gap-2 w-100 mt-3">
                    <form action="{{ route('whatsapp.desconectar') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 font-semibold py-2">
                            <i class="bi bi-plug-fill me-1"></i> Desconectar WhatsApp
                        </button>
                    </form>
                </div>
            @else
                <div>
                    <h5 class="fw-bold text-slate-900 mb-1">Escaneie o QR Code abaixo</h5>
                    <p class="text-muted fs-13 mb-3">Abra o WhatsApp no celular > Aparelhos Conectados > Conectar um Aparelho</p>

                    <div class="bg-white border rounded-4 p-3 mb-3 shadow-sm d-inline-block">
                        @if($instancia && $instancia->qr_code)
                            <img src="{{ $instancia->qr_code }}" alt="QR Code WhatsApp" class="img-fluid rounded-3" style="width:230px;height:230px;object-fit:contain;">
                        @else
                            <div class="text-muted py-5 px-4">
                                <i class="bi bi-qr-code-scan fs-1 d-block mb-2 text-slate-400"></i>
                                <small class="fw-semibold">Nenhum QR Code disponível</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-100 d-flex flex-column gap-2">
                    @if($instancia && $instancia->qr_code)
                        <form action="{{ route('whatsapp.conectar') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-emerald w-100 py-2.5 fw-bold fs-14 shadow-sm">
                                <i class="bi bi-phone-vibrate me-1"></i> Confirmar Conexão do WhatsApp
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('whatsapp.qrcode') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100 py-2 fs-13">
                            <i class="bi bi-arrow-clockwise me-1"></i> Gerar Novo QR Code
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- TEST MESSAGE FORM & DETAILS -->
    <div class="col-lg-7">
        <!-- TEST MESSAGE CARD -->
        <div class="card-custom p-4 mb-4">
            <h5 class="fw-bold text-slate-900 mb-3"><i class="bi bi-send-fill text-emerald-600 me-2"></i>Testar Envio de Mensagem</h5>
            
            <form action="{{ route('whatsapp.testar') }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Telefone do Paciente (com DDD)</label>
                        <input type="text" name="telefone" class="form-control form-control-custom" placeholder="11999999999" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-slate-700 fs-13 mb-1">Mensagem de Lembrete</label>
                        <textarea name="mensagem" class="form-control form-control-custom" rows="3" placeholder="Olá! Sua consulta na clínica está confirmada para amanhã." required></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-emerald fw-bold px-4">
                    <i class="bi bi-paperplane-fill me-2"></i> Enviar Mensagem Instantânea
                </button>
            </form>
        </div>

        <!-- DETAILS CARD -->
        <div class="card-custom p-4">
            <h5 class="fw-bold text-slate-900 mb-3"><i class="bi bi-info-circle-fill text-emerald-600 me-2"></i>Informações da Instância da Clínica</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-500 fs-12 mb-1">IDENTIFICADOR DA CLÍNICA</label>
                    <input type="text" class="form-control bg-slate-50 border-slate-200 fs-13 font-monospace" value="{{ $instancia->instance_id ?? 'Não configurado' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-500 fs-12 mb-1">STATUS DO SERVIÇO</label>
                    <input type="text" class="form-control bg-slate-50 border-slate-200 fs-13 font-monospace" value="{{ strtoupper($instancia->status ?? 'desconectado') }}" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
