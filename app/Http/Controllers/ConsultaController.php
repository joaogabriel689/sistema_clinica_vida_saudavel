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
use App\Models\Clinica;
use App\Services\ConsultaService;
use App\Services\WhatsAppService;


class ConsultaController extends Controller
{
    protected ConsultaService $consultaService;

    

    public function __construct(ConsultaService $consultaService, WhatsAppService $whatsAppService)
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
         

        $query = Consulta::with(['paciente', 'medico', 'convenio']);
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
         

        $query = Consulta::with(['paciente', 'medico', 'convenio'])            ->where('data_hora_inicio', '>=', now());

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

        $medicos = Medico::orderBy('nome')->get();
        $especialidades = Especialidade::orderBy('nome')->get();
        $convenios = Convenio::orderBy('nome')->get();

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
         

        return view('consultas.create', [
            'pacientes' => Paciente::orderBy('nome')->get(),
            'medicos' => Medico::orderBy('nome')->get(),
            'convenios' => Convenio::orderBy('nome')->get(),
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

        $dados = $request->only([
            'data_hora_inicio',
            'data_hora_fim',
            'valor',
            'medico_id',
            'paciente_id',
            'convenio_id',
            'status',
            'observacoes',
        ]);
        $dados['clinica_id'] = $this->clinicaId;

        $this->consultaService->criarConsulta($dados);



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
         

        $consulta = Consulta::with(['paciente', 'medico', 'convenio'])
            ->where('id', $id)
             
            ->firstOrFail();
        $medico = $consulta->medico;
        $paciente = $consulta->paciente;
        $convenio = $consulta->convenio;

        return view('consultas.show', compact('consulta', 'medico', 'paciente', 'convenio'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
         

        $consulta = Consulta::where('id', $id)            ->firstOrFail();

        return view('consultas.edit', [
            'consulta' => $consulta,
            'pacientes' => Paciente::orderBy('nome')->get(),
            'medicos' => Medico::orderBy('nome')->get(),
            'convenios' => Convenio::orderBy('nome')->get(''),
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
         

        $consulta = Consulta::where('id', $id)->firstOrFail();

        // 🔹 atualização completa
        $this->consultaService->atualizarConsulta(
            $consulta,
            $request->validated()
        );

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta atualizada com sucesso.');
    }

    public function confirmarPagamento(string $id)
    {
         

        $consulta = Consulta::where('id', $id)            ->firstOrFail();

        $this->consultaService->confirmarPagamento($consulta);

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Pagamento confirmado.');
    }
    public function alterarStatus(string $id, $request)
    {
         

        $consulta = Consulta::where('id', $id)            ->firstOrFail();

        $status = $request->status;

        $this->consultaService->alterarStatus($consulta, $status);

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Status atualizado.');
    }
    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
         

        $consulta = Consulta::where('id', $id)->firstOrFail();

        $consulta->delete();

        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta cancelada.');
    }
}