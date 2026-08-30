<?php

namespace App\Http\Controllers;

use App\Models\WhatsappInstancia;
use App\Jobs\EnviarNotificacaoWhatsAppJob;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function index()
    {
        $clinicaId = Auth::user()->resolveClinicaId();
        $instancia = WhatsappInstancia::where('clinica_id', $clinicaId)->first();

        if (!$instancia) {
            $instanceName = 'EVOLUTION_TENANT_' . $clinicaId;
            $qrCode = $this->whatsAppService->getQrCode($instanceName);

            $instancia = WhatsappInstancia::create([
                'clinica_id' => $clinicaId,
                'instance_id' => $instanceName,
                'token' => 'EVOLUTION_APIKEY_' . rand(1000, 9999),
                'client_token' => 'CLIENT_TOKEN_EVOLUTION',
                'status' => 'aguardando_qr',
                'qr_code' => $qrCode
            ]);
        }

        return view('whatsapp.index', compact('instancia'));
    }

    public function gerarQrCode(Request $request)
    {
        $clinicaId = Auth::user()->resolveClinicaId();
        $instancia = WhatsappInstancia::where('clinica_id', $clinicaId)->first();

        $instanceName = 'EVOLUTION_TENANT_' . $clinicaId;

        // Tenta criar/obter QR Code na Evolution API
        $this->whatsAppService->createInstance($instanceName);
        $qrCode = $this->whatsAppService->getQrCode($instanceName);

        if (!$instancia) {
            $instancia = new WhatsappInstancia();
            $instancia->clinica_id = $clinicaId;
            $instancia->instance_id = $instanceName;
            $instancia->token = 'EVOLUTION_APIKEY_' . rand(1000, 9999);
            $instancia->client_token = 'CLIENT_TOKEN_EVOLUTION';
        }

        $instancia->status = 'aguardando_qr';
        $instancia->qr_code = $qrCode;
        $instancia->save();

        return redirect()->back()->with('success', 'Novo QR Code Evolution API gerado! Aponte a câmera do seu WhatsApp para conectar.');
    }

    public function conectar(Request $request)
    {
        $clinicaId = Auth::user()->resolveClinicaId();
        $instancia = WhatsappInstancia::where('clinica_id', $clinicaId)->first();

        if ($instancia) {
            $instancia->status = 'conectado';
            $instancia->save();
        }

        return redirect()->back()->with('success', 'WhatsApp pareado e conectado com sucesso via Evolution API (Docker)!');
    }

    public function desconectar(Request $request)
    {
        $clinicaId = Auth::user()->resolveClinicaId();
        $instancia = WhatsappInstancia::where('clinica_id', $clinicaId)->first();

        if ($instancia) {
            $instanceName = $instancia->instance_id ?? ('EVOLUTION_TENANT_' . $clinicaId);
            $this->whatsAppService->logoutInstance($instanceName);

            $instancia->status = 'desconectado';
            $instancia->qr_code = null;
            $instancia->save();
        }

        return redirect()->back()->with('success', 'Instância Evolution API desconectada com sucesso.');
    }

    public function testarEnvio(Request $request)
    {
        $request->validate([
            'telefone' => 'required|string|min:10',
            'mensagem' => 'required|string|max:500'
        ]);

        $clinicaId = Auth::user()->resolveClinicaId();

        // Envia notificação assíncrona na fila do Redis Queue
        EnviarNotificacaoWhatsAppJob::dispatch(
            $request->telefone,
            "[Teste Evolution API Docker] " . $request->mensagem,
            $clinicaId
        );

        return redirect()->back()->with('success', 'Notificação enviada para a fila do Redis Queue (Evolution API)!');
    }
}
