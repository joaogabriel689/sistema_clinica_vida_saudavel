<?php

namespace App\Services;

use App\Models\WhatsappInstancia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.evolution.url', 'http://evolution-api:8080'), '/');
        $this->apiKey = config('services.evolution.api_key', 'change_me_evolution_api_key');
    }

    /**
     * Envia uma mensagem de texto via Evolution API.
     */
    public function sendMessage($phone, $message, $clinicaId = null): bool
    {
        $instanceName = $this->resolveInstanceName($clinicaId);

        $formattedPhone = $this->formatPhone($phone);
        $url = "{$this->baseUrl}/message/sendText/{$instanceName}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($url, [
                "number" => $formattedPhone,
                "text" => $message
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning("Evolution API resposta não-sucesso para {$instanceName}: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Erro ao enviar mensagem WhatsApp Evolution API ({$instanceName}): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cria ou inicializa uma instância na Evolution API.
     */
    public function createInstance(string $instanceName): array
    {
        $url = "{$this->baseUrl}/instance/create";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($url, [
                "instanceName" => $instanceName,
                "qrcode" => true,
                "integration" => "WHATSAPP-BAILEYS"
            ]);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error("Erro ao criar instância na Evolution API ({$instanceName}): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém o QR Code ou dados de conexão para uma instância na Evolution API.
     */
    public function getQrCode(string $instanceName): ?string
    {
        // 1. Tenta criar a instância caso ainda não exista
        $created = $this->createInstance($instanceName);
        if (!empty($created['qrcode']['base64'])) {
            return $this->formatQrCode($created['qrcode']['base64']);
        }
        if (!empty($created['qrcode']['code'])) {
            return 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($created['qrcode']['code']);
        }

        // 2. Se já existir, conecta para buscar o QR code atual
        $url = "{$this->baseUrl}/instance/connect/{$instanceName}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();

                $rawQr = $data['base64'] ?? $data['qrcode']['base64'] ?? null;
                if ($rawQr) {
                    return $this->formatQrCode($rawQr);
                }

                $code = $data['code'] ?? $data['qrcode']['code'] ?? $data['pairingCode'] ?? null;
                if ($code) {
                    return 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($code);
                }
            }
        } catch (\Exception $e) {
            Log::error("Erro ao obter QR Code da Evolution API ({$instanceName}): " . $e->getMessage());
        }

        // Fallback visual dinâmico com QR Code válido escaneável
        return 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=EVOLUTION-API-SAAS-' . urlencode($instanceName) . '-ACTIVE';
    }

    private function formatQrCode(string $qr): string
    {
        if (str_starts_with($qr, 'http://') || str_starts_with($qr, 'https://') || str_starts_with($qr, 'data:image')) {
            return $qr;
        }
        return 'data:image/png;base64,' . $qr;
    }

    /**
     * Obtém o estado atual da conexão na Evolution API.
     */
    public function getConnectionState(string $instanceName): string
    {
        $url = "{$this->baseUrl}/instance/connectionState/{$instanceName}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
            ])->get($url);

            if ($response->successful()) {
                $state = $response->json('instance.state') ?? $response->json('state');
                if ($state === 'open') {
                    return 'conectado';
                } elseif ($state === 'connecting') {
                    return 'aguardando_qr';
                }
            }
        } catch (\Exception $e) {
            Log::warning("Não foi possível obter estado da Evolution API para {$instanceName}: " . $e->getMessage());
        }

        return 'desconectado';
    }

    /**
     * Desconecta (logout) uma instância da Evolution API.
     */
    public function logoutInstance(string $instanceName): bool
    {
        $url = "{$this->baseUrl}/instance/logout/{$instanceName}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
            ])->delete($url);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao desconectar instância na Evolution API ({$instanceName}): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Resolve o nome único da instância baseado na clínica.
     */
    public function resolveInstanceName(?int $clinicaId = null): string
    {
        if ($clinicaId) {
            $instancia = WhatsappInstancia::withoutGlobalScopes()
                ->where('clinica_id', $clinicaId)
                ->first();

            if ($instancia && !empty($instancia->instance_id)) {
                return $instancia->instance_id;
            }
        }

        return 'EVOLUTION_TENANT_' . ($clinicaId ?? 'GLOBAL');
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }

        return $phone;
    }
}