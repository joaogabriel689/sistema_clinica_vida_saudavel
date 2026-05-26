<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\User;
use App\Models\Especialidade;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Requests\UpdateMedicoRequest;
use App\Services\MedicoService;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    protected MedicoService $medicoService;
    protected DashboardService $dashboardService;
    public function __construct(MedicoService $medicoService, DashboardService $dashboardService)
    {
        $this->medicoService = $medicoService;
        $this->dashboardService = $dashboardService;
    }
    public function index(Request $request)
    {


        $query = Medico::with('especialidade');

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->where('nome', 'like', "%{$request->search}%")
                ->orWhere('crm', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");

            });
        }

        $medicos = $query->paginate(10);


        return view('medicos.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = Especialidade::all();
        return view('medicos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicoRequest $request)
    {
        $dados = $request->only([
                    'nome', 'crm', 'especialidade','password', 'nova_especialidade', 'telefone', 'email', 'hora_inicio', 'hora_fim'
                ]);
        $dados['clinica_id'] = $this->clinicaId;
        $this->medicoService->criarMedico($dados);

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico criado com sucesso.');
    }


    public function edit(string $id)
    {

        $medico = Medico::where('id', $id)->firstOrFail();
        $especialidades = Especialidade::all();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicoRequest $request, $id)
    {


        // Busca o médico
        $medico = Medico::where('id', $id)->firstOrFail();

        $dados = $request->only([
            'nome', 'crm', 'especialidade', 'nova_especialidade', 'telefone', 'email', 'hora_inicio', 'hora_fim'
        ]);
        $dados['clinica_id'] = $this->clinicaId;
        $this->medicoService->atualizarMedico($medico, $dados);

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $medico = Medico::where('id', $id)->firstOrFail();
            $user = User::find($medico->user_id);
            $medico->delete();
            if ($user) {
                $user->delete();
            }
        });
        return redirect()->route('admin.medicos')->with('success', 'Médico deletado com sucesso.');
    }
    public function dashboard()
    {
        $dados = $this->dashboardService->medicoDashboard();
        return view('medicos.dashboard', compact('dados'));
    }

    public function porespecialidade($especialidadeId)
    {
        $medicos = Medico::where('especialidade_id', $especialidadeId)
            ->get();
        return response()->json($medicos);
    }
    public function horarios($medicoId)
    {
        $medico = Medico::where('id', $medicoId)->firstOrFail();
        return response()->json([
            'hora_inicio' => $medico->hora_inicio,
            'hora_fim' => $medico->hora_fim
        ]);
    }
}
