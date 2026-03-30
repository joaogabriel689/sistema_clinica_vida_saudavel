<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\User;
use App\Models\Especialidade;
use App\Models\Clinica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Requests\UpdateMedicoRequest;
use App\Services\MedicoService;

class MedicoController extends Controller
{
    protected MedicoService $medicoService;

    public function index(Request $request)
    {


        $query = Medico::with('especialidade')->where('clinica_id', Auth::user()->clinica_id);

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

;

        $especialidades = Especialidade::all();
        return view('medicos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicoRequest $request)
    {

        $this->medicoService->criarMedico($dados = $request->only([
            'nome', 'crm', 'especialidade', 'nova_especialidade', 'telefone', 'email', 'hora_inicio', 'hora_fim'
        ]));

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico criado com sucesso.');
    }


    public function edit(string $id)
    {

        $medico = Medico::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $especialidades = Especialidade::all()->where('clinica_id', Auth::user()->clinica_id);
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicoRequest $request, $id)
    {


        // Busca o médico
        $medico = Medico::findOrFail($id);


        $this->medicoService->atualizarMedico($medico, $dados = $request->only([
            'nome', 'crm', 'especialidade', 'nova_especialidade', 'telefone', 'email', 'hora_inicio', 'hora_fim'
        ]));

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $medico = Medico::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $user = User::find($medico->user_id);
        $medico->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.medicos')->with('success', 'Médico deletado com sucesso.');
    }
    public function dashboard()
    {

        $medico = Medico::where('user_id', Auth::id())->first()->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $agenda_medico_hoje = \App\Models\Consulta::where('medico_id', $medico->id)
            ->whereDate('data_hora_inicio', now()->toDateString())
            ->with('paciente')
            ->orderBy('data_hora_inicio')
            ->get()->where('clinica_id', Auth::user()->clinica_id);
        return view('medicos.dashboard', compact('medico', 'agenda_medico_hoje'));
    }

    public function porespecialidade($especialidadeId)
    {
        $medicos = Medico::where('especialidade_id', $especialidadeId)->get()->where('clinica_id', Auth::user()->clinica_id);
        return response()->json($medicos);
    }
    public function horarios($medicoId)
    {
        $medico = Medico::findOrFail($medicoId)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        return response()->json([
            'horario_inicio' => $medico->horario_inicio,
            'horario_fim' => $medico->horario_fim
        ]);
    }
}
