<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Convenio;
use App\Models\Especialidade;
use App\Http\Requests\StoreConsultaRequest;
use App\Http\Requests\UpdateConsultaRequest;
use App\Services\ConsultaService;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    protected ConsultaService $consultaService;
    

    public function __construct(ConsultaService $consultaService)
    {
        $this->consultaService = $consultaService;
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM PRINCIPAL
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $clinicaId = Auth::user()->clinica_id;

        $query = Consulta::with(['paciente', 'medico', 'convenio'])
            ->where('clinica_id', $clinicaId);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('paciente', fn($p) =>
                    $p->where('nome', 'like', "%{$request->search}%")
                )->orWhereHas('medico', fn($m) =>
                    $m->where('nome', 'like', "%{$request->search}%")
                );
            });
        }

        $consultas = $query->latest()->paginate(10);

        return view('consultas.index', compact('consultas'));
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM AVANÇADA (FILTROS)
    |--------------------------------------------------------------------------
    */

    public function list(Request $request)
    {
        $clinicaId = Auth::user()->clinica_id;

        $query = Consulta::with(['paciente', 'medico', 'convenio'])
            ->where('clinica_id', $clinicaId)
            ->where('data_hora_inicio', '>=', now());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('paciente', fn($p) =>
                    $p->where('nome', 'like', "%{$request->search}%")
                )->orWhereHas('medico', fn($m) =>
                    $m->where('nome', 'like', "%{$request->search}%")
                );
            });
        }

        if ($request->data) {
            $query->whereDate('data_hora_inicio', $request->data);
        }

        if ($request->medico) {
            $query->where('medico_id', $request->medico);
        }

        if ($request->convenio) {
            $query->where('convenio_id', $request->convenio);
        }

        $consultas = $query->orderBy('data_hora_inicio')->paginate(10);

        $medicos = Medico::where('clinica_id', $clinicaId)->orderBy('nome')->get();
        $especialidades = Especialidade::orderBy('nome')->get();
        $convenios = Convenio::where('clinica_id', $clinicaId)->orderBy('nome')->get();

        return view('consultas.list_all', compact(
            'consultas',
            'medicos',
            'especialidades',
            'convenios'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $clinicaId = Auth::user()->clinica_id;

        return view('consultas.create', [
            'pacientes' => Paciente::where('clinica_id', $clinicaId)->get(),
            'medicos' => Medico::where('clinica_id', $clinicaId)->get(),
            'convenios' => Convenio::where('clinica_id', $clinicaId)->get(),
            'especialidades' => Especialidade::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(StoreConsultaRequest $request)
    {


        $this->consultaService->criarConsulta($request->all());

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta agendada com sucesso.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(string $id)
    {
        $clinicaId = Auth::user()->clinica_id;

        $consulta = Consulta::with(['paciente', 'medico', 'convenio'])
            ->where('id', $id)
            ->where('clinica_id', $clinicaId)
            ->firstOrFail();

        return view('consultas.show', compact('consulta'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
        $clinicaId = Auth::user()->clinica_id;

        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', $clinicaId)
            ->firstOrFail();

        return view('consultas.edit', [
            'consulta' => $consulta,
            'pacientes' => Paciente::where('clinica_id', $clinicaId)->get(),
            'medicos' => Medico::where('clinica_id', $clinicaId)->get(),
            'convenios' => Convenio::where('clinica_id', $clinicaId)->get(),
            'especialidades' => Especialidade::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(UpdateConsultaRequest $request, string $id)
    {
        $clinicaId = Auth::user()->clinica_id;

        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', $clinicaId)
            ->firstOrFail();

        // 🔹 atualização rápida
        if ($request->has('status') || $request->has('pago')) {

            if ($request->has('status')) {
                $consulta->status = $request->status;
            }

            if ($request->has('pago')) {
                $consulta->pago = (bool) $request->pago;
            }

            $consulta->save();

            return redirect()->route('consultas.list')
                ->with('success', 'Consulta atualizada.');
        }



        $this->consultaService->atualizarConsulta($consulta, $request->all());

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta atualizada com sucesso.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
        $clinicaId = Auth::user()->clinica_id;

        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', $clinicaId)
            ->firstOrFail();

        $consulta->delete();

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta cancelada.');
    }
}