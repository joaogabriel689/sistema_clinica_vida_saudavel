<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Assinatura;
use App\Models\Plano;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Fatura;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    /**
     * Dashboard Global de Métricas SaaS.
     */
    public function dashboard()
    {
        // 💰 Cálculo de MRR (Receita Mensal Recorrente) e ARR
        $assinaturasAtivas = Assinatura::withoutGlobalScopes()
            ->where('status', 'ativa')
            ->with('plano')
            ->get();

        $mrr = $assinaturasAtivas->sum(function ($ass) {
            return $ass->plano->preco_mensal ?? $ass->plano->preco ?? 0;
        });

        $arr = $mrr * 12;

        // 📊 Contadores de Saúde SaaS
        $totalClinicas = Clinica::count();
        $clinicasAtivas = Assinatura::withoutGlobalScopes()->where('status', 'ativa')->count();
        $clinicasTrial = Assinatura::withoutGlobalScopes()->where('status', 'trial')->count();
        $clinicasInadimplentes = Assinatura::withoutGlobalScopes()->whereIn('status', ['inadimplente', 'suspensa'])->count();

        $totalPacientes = Paciente::withoutGlobalScopes()->count();
        $totalConsultas = Consulta::withoutGlobalScopes()->count();

        // 🏥 Últimas 10 clínicas cadastradas
        $ultimasClinicas = Clinica::latest()->take(10)->with('user')->get();

        // 💳 Distribuição de Planos
        $planosMaisVendidos = Plano::withCount(['assinaturas' => function ($q) {
            $q->withoutGlobalScopes();
        }])->get();

        return view('superadmin.dashboard', compact(
            'mrr',
            'arr',
            'totalClinicas',
            'clinicasAtivas',
            'clinicasTrial',
            'clinicasInadimplentes',
            'totalPacientes',
            'totalConsultas',
            'ultimasClinicas',
            'planosMaisVendidos'
        ));
    }

    /**
     * Gestão Global de Clínicas Cadastradas.
     */
    public function clinicas(Request $request)
    {
        $query = Clinica::with(['user', 'medicos', 'recepcionistas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('cnpj', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $clinicas = $query->latest()->paginate(15);
        $planos = Plano::where('ativo', true)->get();

        // Mapeia assinaturas ativas por clínica
        $assinaturasMap = Assinatura::withoutGlobalScopes()
            ->with('plano')
            ->get()
            ->keyBy('clinica_id');

        return view('superadmin.clinicas.index', compact('clinicas', 'planos', 'assinaturasMap'));
    }

    /**
     * Atualiza Status ou Plano de uma Clínica Manualmente.
     */
    public function atualizarClinica(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:ativa,trial,inadimplente,suspensa',
            'plano_id' => 'required|exists:planos,id',
        ]);

        $clinica = Clinica::findOrFail($id);

        $assinatura = Assinatura::withoutGlobalScopes()
            ->where('clinica_id', $clinica->id)
            ->first();

        if ($assinatura) {
            $assinatura->update([
                'status' => $request->status,
                'plano_id' => $request->plano_id,
            ]);
        } else {
            Assinatura::create([
                'clinica_id' => $clinica->id,
                'plano_id' => $request->plano_id,
                'status' => $request->status,
                'proxima_cobranca' => now()->addDays(30),
                'gateway' => 'manual',
            ]);
        }

        return redirect()->back()->with('success', "Status e plano da clínica \"{$clinica->nome}\" atualizados com sucesso!");
    }

    /**
     * Lista de Planos e Valores do SaaS.
     */
    public function planos()
    {
        $planos = Plano::withCount(['assinaturas' => function ($q) {
            $q->withoutGlobalScopes();
        }])->get();

        return view('superadmin.planos.index', compact('planos'));
    }

    /**
     * Cria um novo Plano de Assinatura.
     */
    public function criarPlano(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'limite_medicos' => 'required|integer|min:1',
            'limite_recepcionistas' => 'required|integer|min:1',
            'descricao' => 'nullable|string|max:1000',
        ]);

        $slug = Str::slug($request->nome);

        Plano::create([
            'nome' => $request->nome,
            'slug' => $slug,
            'preco_mensal' => $request->preco,
            'max_medicos' => $request->limite_medicos,
            'max_recepcionistas' => $request->limite_recepcionistas,
            'max_consultas_mes' => 9999,
            'descricao' => $request->descricao,
            'ativo' => true,
        ]);

        return redirect()->route('superadmin.planos')->with('success', 'Novo plano criado com sucesso!');
    }

    /**
     * Tela de Edição de um Plano Existente.
     */
    public function editarPlano($id)
    {
        $plano = Plano::findOrFail($id);
        return view('superadmin.planos.edit', compact('plano'));
    }

    /**
     * Atualiza um Plano Existente e seus Valores.
     */
    public function atualizarPlano(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'limite_medicos' => 'required|integer|min:1',
            'limite_recepcionistas' => 'required|integer|min:1',
            'descricao' => 'nullable|string|max:1000',
            'ativo' => 'nullable|boolean',
        ]);

        $plano->update([
            'nome' => $request->nome,
            'preco_mensal' => $request->preco,
            'max_medicos' => $request->limite_medicos,
            'max_recepcionistas' => $request->limite_recepcionistas,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('superadmin.planos')->with('success', "Plano \"{$plano->nome}\" atualizado com sucesso!");
    }
}
