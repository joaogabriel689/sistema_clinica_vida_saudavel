<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;
use App\Models\Assinatura;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WebhookController extends Controller
{
    /**
     * Recebe e processa Webhooks enviados pelo Asaas.
     */
    public function asaas(Request $request)
    {
        // 🔒 Segurança: Autenticação do Token de Webhook (Header asaas-access-token)
        $expectedToken = config('services.asaas.webhook_token');
        if (!empty($expectedToken) && $expectedToken !== 'change_me_asaas_webhook_token') {
            $receivedToken = $request->header('asaas-access-token');
            if ($receivedToken !== $expectedToken) {
                Log::warning('Tentativa de webhook Asaas não autorizado (Token inválido)', [
                    'ip' => $request->ip(),
                    'received_token' => $receivedToken ? 'FORNECIDO' : 'AUSENTE'
                ]);
                return response()->json(['error' => 'Token de webhook inválido.'], 401);
            }
        }

        $event = $request->input('event');
        $payment = $request->input('payment');

        Log::info('Webhook Asaas recebido com sucesso:', [
            'event' => $event,
            'payment_id' => $payment['id'] ?? null,
            'subscription_id' => $payment['subscription'] ?? null,
        ]);

        $paymentId = $payment['id'] ?? null;
        $subscriptionId = $payment['subscription'] ?? null;

        // Processa confirmações e pagamentos recebidos
        if (in_array($event, ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED'])) {
            $fatura = Fatura::where('id', $paymentId)
                ->orWhere('id', str_replace('pay_', '', (string)$paymentId))
                ->first();

            // Se a fatura ainda não existir no banco local, busca por assinatura
            if (!$fatura && $subscriptionId) {
                $assinatura = Assinatura::withoutGlobalScopes()
                    ->where('asaas_subscription_id', $subscriptionId)
                    ->orWhere('subscription_gateway_id', $subscriptionId)
                    ->first();

                if ($assinatura) {
                    $fatura = Fatura::create([
                        'id' => $paymentId,
                        'clinica_id' => $assinatura->clinica_id,
                        'assinatura_id' => $assinatura->id,
                        'valor' => $payment['value'] ?? 150.00,
                        'status' => 'paga',
                        'data_vencimento' => $payment['dueDate'] ?? Carbon::now(),
                        'data_pagamento' => Carbon::now(),
                    ]);
                }
            } else if ($fatura) {
                $fatura->update([
                    'status' => 'paga',
                    'data_pagamento' => Carbon::now(),
                ]);
            }

            // Atualiza a assinatura para ATIVA
            $assinaturaId = $fatura->assinatura_id ?? null;
            if ($assinaturaId) {
                $assinatura = Assinatura::withoutGlobalScopes()
                    ->where('id', $assinaturaId)
                    ->first();

                if ($assinatura) {
                    $assinatura->update([
                        'status' => 'ativa',
                        'proxima_cobranca' => Carbon::now()->addDays(30),
                    ]);
                }
            }
        } 
        // Processa inadimplência e atraso de faturas
        elseif (in_array($event, ['PAYMENT_OVERDUE'])) {
            $fatura = Fatura::where('id', $paymentId)
                ->orWhere('id', str_replace('pay_', '', (string)$paymentId))
                ->first();

            if ($fatura) {
                $fatura->update(['status' => 'vencida']);

                $assinatura = Assinatura::withoutGlobalScopes()
                    ->where('id', $fatura->assinatura_id)
                    ->first();

                if ($assinatura) {
                    $assinatura->update(['status' => 'inadimplente']);
                }
            }
        }
        // Processa estornos
        elseif (in_array($event, ['PAYMENT_REFUNDED', 'PAYMENT_DELETED'])) {
            $fatura = Fatura::where('id', $paymentId)
                ->orWhere('id', str_replace('pay_', '', (string)$paymentId))
                ->first();

            if ($fatura) {
                $fatura->update(['status' => 'cancelada']);
            }
        }

        return response()->json(['status' => 'success', 'event_processed' => $event]);
    }
}
