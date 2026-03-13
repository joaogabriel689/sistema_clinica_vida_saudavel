<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Convenio;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{

    /**
     * Dashboard da recepcionista
     */
    public function index(Request $request)
    {
        // Verifica se usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Apenas recepcionistas podem acessar
        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $query = Consulta::with([
            'paciente',
            'medico',
            'especialidade',
            'convenio'
        ]);

        if ($request->search) {

            $query->whereHas('paciente', function ($q) use ($request) {
                $q->where('nome', 'like', "%{$request->search}%");
            })
            ->orWhereHas('medico', function ($q) use ($request) {
                $q->where('nome', 'like', "%{$request->search}%");
            });

        }

        $consultas = $query->paginate(10);

        return view('consultas.index', compact(
            'consultas',
            'consultas_do_dia',
            'consultas_do_mes',
            'consultas_pendentes_confirmacao',
            'consultas_canceladas'
        ));
    }


    /**
     * Lista todas as consultas futuras
     */
    public function list(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $query = Consulta::with([
            'paciente',
            'medico',
            'especialidade',
            'convenio'
        ]);


        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->whereHas('paciente', function ($p) use ($request) {
                    $p->where('nome','like',"%{$request->search}%");
                })

                ->orWhereHas('medico', function ($m) use ($request) {
                    $m->where('nome','like',"%{$request->search}%");
                });

            });

        }


        if ($request->data) {
            $query->whereDate('data_hora_inicio', $request->data);
        }

        if ($request->medico) {
            $query->where('medico_id', $request->medico);
        }

        if ($request->especialidade) {
            $query->where('especialidade_id', $request->especialidade);
        }

        if ($request->convenio) {
            $query->where('convenio_id', $request->convenio);
        }


        $consultas = $query->orderBy('data_hora_inicio')
                        ->paginate(10);


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

    /**
     * Formulário de criação de consulta
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        // Carrega dados necessários para o formulário
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        $convenios = Convenio::all();
        $especialidades = Especialidade::all();

        return view('consultas.create', compact(
            'pacientes',
            'medicos',
            'convenios',
            'especialidades'
        ));
    }


    /**
     * Salva nova consulta
     */
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        // Validação dos dados
        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'valor' => 'required|numeric',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'observacoes' => 'nullable|string',
        ]);

        // Aplica desconto do convênio (se existir)
        $convenio = Convenio::find($request->convenio_id);
        $desconto = $convenio ? $convenio->desconto : 0;

        $request->merge([
            'valor' => $request->valor * (1 - $desconto / 100)
        ]);

        $data_inicio = $request->input('data_hora_inicio');
        $data_fim = $request->input('data_hora_fim');

        // Verifica conflito de horário do médico
        if (Consulta::where('medico_id', $request->medico_id)
            ->where(function ($query) use ($data_inicio, $data_fim) {

                $query->whereBetween('data_hora_inicio', [$data_inicio, $data_fim])
                    ->orWhereBetween('data_hora_fim', [$data_inicio, $data_fim])
                    ->orWhere(function ($query) use ($data_inicio, $data_fim) {

                        $query->where('data_hora_inicio', '<=', $data_inicio)
                            ->where('data_hora_fim', '>=', $data_fim);

                    });

            })->exists()) {

            return redirect()->back()
                ->with('error', 'O médico selecionado já possui uma consulta agendada nesse horário.');

        }

        // Cria consulta
        Consulta::create($request->all());

        return redirect()->route('consultas.list')
            ->with('success', 'Consulta agendada com sucesso.');

    }


    /**
     * Exibe detalhes da consulta
     */
    public function show(string $id)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $consulta = Consulta::findOrFail($id);

        // Relacionamentos
        $paciente = $consulta->paciente;
        $medico = $consulta->medico;
        $convenio = $consulta->convenio;

        return view('consultas.show', compact(
            'consulta',
            'paciente',
            'medico',
            'convenio'
        ));

    }


    /**
     * Formulário de edição
     */
    public function edit(string $id)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $consulta = Consulta::findOrFail($id);

        $pacientes = Paciente::all();
        $medicos = Medico::all();
        $convenios = Convenio::all();
        $especialidades = Especialidade::all();

        return view('consultas.edit', compact(
            'consulta',
            'pacientes',
            'medicos',
            'convenios',
            'especialidades'
        ));

    }


    /**
     * Atualiza consulta
     */
    public function update(Request $request, string $id)
    {

        // segurança
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $consulta = Consulta::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Atualização rápida (status ou pagamento)
        |--------------------------------------------------------------------------
        */

        if ($request->has('status') || $request->has('pago')) {

            if ($request->status) {
                $consulta->status = $request->status;
            }

            if ($request->pago) {
                $consulta->pago = true;
            }

            $consulta->save();

            return redirect()
                ->route('consultas.list')
                ->with('success', 'Consulta atualizada com sucesso.');

        }


        /*
        |--------------------------------------------------------------------------
        | Atualização completa da consulta
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'valor' => 'required|numeric',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'observacoes' => 'nullable|string',
        ]);


        $data_inicio = $request->data_hora_inicio;
        $data_fim = $request->data_hora_fim;


        /*
        |--------------------------------------------------------------------------
        | Verifica conflito de horário
        |--------------------------------------------------------------------------
        */

        $existeConflito = Consulta::where('medico_id', $request->medico_id)
            ->where('id', '!=', $consulta->id)
            ->where(function ($query) use ($data_inicio, $data_fim) {

                $query->whereBetween('data_hora_inicio', [$data_inicio, $data_fim])

                ->orWhereBetween('data_hora_fim', [$data_inicio, $data_fim])

                ->orWhere(function ($query) use ($data_inicio, $data_fim) {

                    $query->where('data_hora_inicio', '<=', $data_inicio)
                        ->where('data_hora_fim', '>=', $data_fim);

                });

            })
            ->exists();


        if ($existeConflito) {

            return redirect()->back()
                ->with('error', 'O médico selecionado já possui uma consulta nesse horário.');

        }


        /*
        |--------------------------------------------------------------------------
        | Recalcula valor com desconto do convênio
        |--------------------------------------------------------------------------
        */

        $convenio = Convenio::find($request->convenio_id);

        $desconto = $convenio ? $convenio->desconto : 0;

        $valorFinal = $request->valor * (1 - $desconto / 100);


        /*
        |--------------------------------------------------------------------------
        | Atualiza consulta
        |--------------------------------------------------------------------------
        */

        $consulta->update([

            'data_hora_inicio' => $request->data_hora_inicio,
            'data_hora_fim' => $request->data_hora_fim,
            'valor' => $valorFinal,
            'medico_id' => $request->medico_id,
            'paciente_id' => $request->paciente_id,
            'convenio_id' => $request->convenio_id,
            'observacoes' => $request->observacoes,

        ]);


        return redirect()
            ->route('consultas.list')
            ->with('success', 'Consulta atualizada com sucesso.');

    }


    /**
     * Cancela (exclui) consulta
     */
    public function destroy(string $id)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $consulta = Consulta::findOrFail($id);

        $consulta->delete();

        return redirect()->route('consultas.list')
            ->with('success', 'Consulta cancelada com sucesso.');

    }

}