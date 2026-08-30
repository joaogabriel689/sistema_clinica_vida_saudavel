<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Fatura;
use App\Models\Plano;
use App\Models\Medico;
use App\Models\Consulta;
use App\Models\Clinica;
use App\Services\AsaasService;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    protected AsaasService $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }

    public function index()
    {
        $clinicaId = auth()->user()->resolveClinicaId();
        $clinica = Clinica::find($clinicaId);

        $planos = Plano::where('ativo', true)->get();
        if ($planos->isEmpty()) {
            (new \Database\Seeders\PlanoSeeder())->run();
            $planos = Plano::where('ativo', true)->get();
        }

        $assinatura = Assinatura::where('clinica_id', $clinicaId)->with('plano')->first();

        if (!$assinatura) {
            $planoPro = $planos->where('slug', 'pro')->first() ?? $planos->first();
            $assinatura = Assinatura::create([
                'clinica_id' => $clinicaId,
                'plano_id' => $planoPro->id,
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(14),
                'proxima_cobranca' => now()->addDays(14),
                'gateway' => 'asaas'
            ]);
        }

        $faturas = $assinatura ? $assinatura->faturas()->latest()->get() : collect();

        $medicosCount = Medico::count();
        $consultasMesCount = Consulta::whereMonth('created_at', now()->month)->count();

        return view('billing.index', compact('assinatura', 'planos', 'faturas', 'medicosCount', 'consultasMesCount', 'clinica'));
    }

    public function mudarPlano(Request $request)
    {
        $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'billing_type' => 'nullable|string|in:PIX,BOLETO,CREDIT_CARD'
        ]);

        $clinicaId = auth()->user()->resolveClinicaId();
        $clinica = Clinica::findOrFail($clinicaId);
        $plano = Plano::findOrFail($request->plano_id);
        $billingType = $request->input('billing_type', 'PIX');

        $assinatura = Assinatura::where('clinica_id', $clinicaId)->first();

        // Comunicação com o Gateway Asaas
        $asaasResult = $this->asaasService->createSubscription($clinica, $plano, $billingType);

        if ($assinatura) {
            $assinatura->plano_id = $plano->id;
            $assinatura->gateway = 'asaas';
            if ($asaasResult['success']) {
                $assinatura->asaas_subscription_id = $asaasResult['subscription_id'];
                $assinatura->status = 'ativa';
            } else {
                $assinatura->status = 'ativa'; // Atualização local se gateway em sandbox/offline
            }
            $assinatura->save();
        }

        // Gera fatura pendente local para registro de histórico
        $fatura = Fatura::create([
            'clinica_id' => $clinicaId,
            'assinatura_id' => $assinatura->id ?? null,
            'valor' => $plano->preco,
            'status' => 'pendente',
            'data_vencimento' => now()->addDays(3),
        ]);

        // Busca dados de Pix se for Pix
        $pixData = null;
        if ($asaasResult['success'] && !empty($asaasResult['subscription_id'])) {
            $payments = $this->asaasService->getSubscriptionPayments($asaasResult['subscription_id']);
            if (!empty($payments[0]['id'])) {
                $fatura->update(['id' => $payments[0]['id']]);
                $pixData = $this->asaasService->getPaymentPixQrCode($payments[0]['id']);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Plano atualizado com sucesso!',
                'pix' => $pixData
            ]);
        }

        return redirect()->back()->with('success', 'Plano da clínica atualizado com sucesso com faturamento Asaas!');
    }
}
