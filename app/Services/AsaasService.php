<?php

namespace App\Services;

use App\Models\Clinica;
use App\Models\Plano;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.asaas.url', 'https://sandbox.asaas.com/api/v3');
        $this->apiKey = config('services.asaas.api_key', '');
    }

    /**
     * Retorna um cliente Http configurado com os headers necessários para a API do Asaas.
     */
    protected function client()
    {
        return Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json',
            'User-Agent' => 'SistemaClinicaVidaSaudavel/1.0',
        ]);
    }

    /**
     * Cria ou localiza o cadastro de um Cliente (Clínica) na API v3 do Asaas.
     */
    public function createOrUpdateCustomer(Clinica $clinica): ?string
    {
        if ($clinica->asaas_customer_id) {
            return $clinica->asaas_customer_id;
        }

        try {
            // Limpa formatação do CNPJ/CPF se houver
            $cpfCnpj = preg_replace('/\D/', '', $clinica->cnpj ?? '');
            
            // Tenta buscar cliente existente por CPF/CNPJ ou e-mail
            if ($cpfCnpj) {
                $search = $this->client()->get("{$this->baseUrl}/customers", [
                    'cpfCnpj' => $cpfCnpj,
                ]);

                if ($search->successful() && !empty($search->json('data.0.id'))) {
                    $customerId = $search->json('data.0.id');
                    $clinica->update(['asaas_customer_id' => $customerId]);
                    return $customerId;
                }
            }

            // Se não encontrou, cria novo cliente no Asaas
            $email = $clinica->user->email ?? "clinica_{$clinica->id}@saas.local";
            $response = $this->client()->post("{$this->baseUrl}/customers", [
                'name' => $clinica->nome,
                'email' => $email,
                'phone' => preg_replace('/\D/', '', $clinica->telefone ?? '11999999999'),
                'cpfCnpj' => $cpfCnpj ?: null,
                'externalReference' => (string)$clinica->id,
            ]);

            if ($response->successful()) {
                $customerId = $response->json('id');
                $clinica->update(['asaas_customer_id' => $customerId]);
                return $customerId;
            }

            Log::error("Falha ao criar cliente no Asaas para clínica {$clinica->id}: " . $response->body());
        } catch (\Exception $e) {
            Log::error("Erro na comunicação com Asaas (createCustomer): " . $e->getMessage());
        }

        return null;
    }

    /**
     * Cria uma assinatura recorrente no Asaas.
     */
    public function createSubscription(Clinica $clinica, Plano $plano, string $billingType = 'PIX'): array
    {
        $customerId = $this->createOrUpdateCustomer($clinica);

        if (!$customerId) {
            return [
                'success' => false,
                'message' => 'Não foi possível registrar o cliente no gateway Asaas.'
            ];
        }

        try {
            $response = $this->client()->post("{$this->baseUrl}/subscriptions", [
                'customer' => $customerId,
                'billingType' => strtoupper($billingType),
                'value' => (float)$plano->preco,
                'nextDueDate' => now()->addDays(1)->format('Y-m-d'),
                'cycle' => 'MONTHLY',
                'description' => "Assinatura Plano {$plano->nome} - Clínica {$clinica->nome}",
                'externalReference' => "clinica_{$clinica->id}_plano_{$plano->id}",
            ]);

            if ($response->successful()) {
                $subData = $response->json();
                return [
                    'success' => true,
                    'subscription_id' => $subData['id'],
                    'data' => $subData
                ];
            }

            Log::error("Falha ao criar assinatura Asaas: " . $response->body());
            return [
                'success' => false,
                'message' => 'Erro retornado pelo gateway Asaas: ' . ($response->json('errors.0.description') ?? 'Falha ao processar')
            ];
        } catch (\Exception $e) {
            Log::error("Exceção ao criar assinatura Asaas: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro interno ao conectar ao serviço de pagamentos.'
            ];
        }
    }

    /**
     * Obtém QRCode Pix e linha de copia e cola de uma cobrança do Asaas.
     */
    public function getPaymentPixQrCode(string $paymentId): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/payments/{$paymentId}/pixQrCode");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'encodedImage' => $response->json('encodedImage'),
                    'payload' => $response->json('payload'),
                    'expirationDate' => $response->json('expirationDate')
                ];
            }
        } catch (\Exception $e) {
            Log::error("Erro ao obter Pix QrCode para pagamento {$paymentId}: " . $e->getMessage());
        }

        return ['success' => false];
    }

    /**
     * Lista cobranças associadas a uma assinatura no Asaas.
     */
    public function getSubscriptionPayments(string $subscriptionId): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/subscriptions/{$subscriptionId}/payments");
            if ($response->successful()) {
                return $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            Log::error("Erro ao buscar cobranças da assinatura {$subscriptionId}: " . $e->getMessage());
        }

        return [];
    }

    /**
     * Cancela uma assinatura ativa no Asaas.
     */
    public function cancelSubscription(string $subscriptionId): bool
    {
        try {
            $response = $this->client()->delete("{$this->baseUrl}/subscriptions/{$subscriptionId}");
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao cancelar assinatura {$subscriptionId} no Asaas: " . $e->getMessage());
            return false;
        }
    }
}
