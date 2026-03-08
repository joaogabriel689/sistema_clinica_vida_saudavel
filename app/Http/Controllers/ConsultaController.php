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
    public function index()
    {
        // Verifica se usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Apenas recepcionistas podem acessar
        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        // Total de consultas do dia
        $consultas_do_dia = Consulta::whereDate('data_hora_inicio', now()->toDateString())->count();

        // Total de consultas do mês
        $consultas_do_mes = Consulta::whereMonth('data_hora_inicio', now()->month)->count();

        // Consultas pendentes
        $consultas_pendentes_confirmacao = Consulta::where('status', 'pendente')->count();

        // Consultas canceladas
        $consultas_canceladas = Consulta::where('status', 'cancelada')->count();

        return view('recepcionista.dashboard', compact(
            'consultas_do_dia',
            'consultas_do_mes',
            'consultas_pendentes_confirmacao',
            'consultas_canceladas'
        ));
    }


    /**
     * Lista todas as consultas futuras
     */
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        // Busca consultas futuras ordenadas por data
        $consultas = Consulta::where('data_hora_inicio', '>=', now())
            ->orderBy('data_hora_inicio')
            ->get();

        return view('consultas.list_all', compact('consultas'));
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

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'recepcionista') {
            return redirect()->route('index');
        }

        $consulta = Consulta::findOrFail($id);

        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'valor' => 'required|numeric',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'observacoes' => 'nullable|string',
        ]);

        $data_inicio = $request->input('data_hora_inicio');
        $data_fim = $request->input('data_hora_fim');

        // Verifica conflito de horário (ignora a própria consulta)
        if (Consulta::where('medico_id', $request->medico_id)
            ->where('id', '!=', $consulta->id)
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

        // Recalcula desconto do convênio
        $convenio = Convenio::find($request->convenio_id);
        $desconto = $convenio ? $convenio->desconto : 0;

        $request->merge([
            'valor' => $request->valor * (1 - $desconto / 100)
        ]);

        // Atualiza consulta
        $consulta->update($request->all());

        return redirect()->route('consultas.list')
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