<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Convenio;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ConsultaController extends Controller
{

    /**
     * Dashboard da recepcionista
     */
    public function index(Request $request)
    {


        $query = Consulta::with([
            'paciente',
            'medico',
            'especialidade',
            'convenio'
        ])->where('clinica_id', Auth::user()->clinica_id);

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


        $query = Consulta::with([
            'paciente',
            'medico',
            'especialidade',
            'convenio'
        ])->where('clinica_id', Auth::user()->clinica_id)->where('data_hora_inicio', '>=', now())->orderBy('data_hora_inicio');


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


        $medicos = Medico::orderBy('nome')->get()->where('clinica_id', Auth::user()->clinica_id);
        $especialidades = Especialidade::orderBy('nome')->get()->where('clinica_id', Auth::user()->clinica_id);
        $convenios = Convenio::orderBy('nome')->get()->where('clinica_id', Auth::user()->clinica_id);


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


        // Carrega dados necessários para o formulário
        $pacientes = Paciente::all()->where('clinica_id', Auth::user()->clinica_id);
        $medicos = Medico::all()->where('clinica_id', Auth::user()->clinica_id);
        $convenios = Convenio::all()->where('clinica_id', Auth::user()->clinica_id);
        $especialidades = Especialidade::all()->where('clinica_id', Auth::user()->clinica_id);

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
        $clinicaId = Auth::user()->clinica_id;

        if (!$clinicaId) {
            return redirect()->back()->with('error', 'Usuário sem clínica vinculada.');
        }

        // ✅ VALIDAÇÃO
        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'valor' => 'required|numeric|min:0',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'observacoes' => 'nullable|string',
        ]);

        // ✅ CARBON (datas seguras)
        $dataInicio = Carbon::parse($request->data_hora_inicio);
        $dataFim = Carbon::parse($request->data_hora_fim);

        if ($dataInicio < now() || $dataFim < now()) {
            return back()->with('error', 'A consulta deve ser no futuro.');
        }

        // ✅ GARANTE QUE TUDO É DA MESMA CLÍNICA
        $medico = Medico::where('id', $request->medico_id)
            ->where('clinica_id', $clinicaId)
            ->first();

        $paciente = Paciente::where('id', $request->paciente_id)
            ->where('clinica_id', $clinicaId)
            ->first();

        if (!$medico || !$paciente) {
            return back()->with('error', 'Dados inválidos para esta clínica.');
        }

        // ✅ CONVÊNIO
        $desconto = 0;

        if ($request->convenio_id) {
            $convenio = Convenio::where('id', $request->convenio_id)
                ->where('clinica_id', $clinicaId)
                ->first();

            if (!$convenio) {
                return back()->with('error', 'Convênio inválido.');
            }

            $desconto = $convenio->percentual_desconto;
        }

        $valorFinal = $request->valor * (1 - $desconto / 100);

        // ✅ HORÁRIO DO MÉDICO
        if (
            $dataInicio->format('H:i') < $medico->horario_inicio ||
            $dataFim->format('H:i') > $medico->horario_fim
        ) {
            return back()->with('error', 'Fora do horário do médico.');
        }

        // ✅ CONFLITO PACIENTE
        $conflitoPaciente = Consulta::where('paciente_id', $paciente->id)
            ->where('clinica_id', $clinicaId)
            ->where(function ($q) use ($dataInicio, $dataFim) {
                $q->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                    $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                });
            })
            ->exists();

        if ($conflitoPaciente) {
            return back()->with('error', 'Paciente já possui consulta nesse horário.');
        }

        // ✅ CONFLITO MÉDICO
        $conflitoMedico = Consulta::where('medico_id', $medico->id)
            ->where('clinica_id', $clinicaId)
            ->where(function ($q) use ($dataInicio, $dataFim) {
                $q->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                    $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                });
            })
            ->exists();

        if ($conflitoMedico) {
            return back()->with('error', 'Médico já possui consulta nesse horário.');
        }

        // ✅ CREATE SEGURO
        Consulta::create([
            'data_hora_inicio' => $dataInicio,
            'data_hora_fim' => $dataFim,
            'valor' => $valorFinal,
            'medico_id' => $medico->id,
            'paciente_id' => $paciente->id,
            'convenio_id' => $request->convenio_id,
            'observacoes' => $request->observacoes,
            'clinica_id' => $clinicaId,
        ]);

        return redirect()->route('consultas.list')
            ->with('success', 'Consulta agendada com sucesso.');
    }


    /**
     * Exibe detalhes da consulta
     */
    public function show(string $id)
    {


        $consulta = Consulta::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();

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



        $consulta = Consulta::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();

        $pacientes = Paciente::all()->where('clinica_id', Auth::user()->clinica_id);
        $medicos = Medico::all()->where('clinica_id', Auth::user()->clinica_id);
        $convenios = Convenio::all()->where('clinica_id', Auth::user()->clinica_id);
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
        $clinicaId = Auth::user()->clinica_id;

        // 🔒 garante que a consulta pertence à clínica
        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', $clinicaId)
            ->firstOrFail();

        /*
        |----------------------------------------------------------------------
        | Atualização rápida
        |----------------------------------------------------------------------
        */

        if ($request->has('status') || $request->has('pago')) {

            if ($request->has('status')) {
                $consulta->status = $request->status;
            }

            if ($request->has('pago')) {
                $consulta->pago = (bool) $request->pago;
            }

            $consulta->save();

            return redirect()
                ->route('consultas.list')
                ->with('success', 'Consulta atualizada.');
        }

        /*
        |----------------------------------------------------------------------
        | Validação
        |----------------------------------------------------------------------
        */

        $request->validate([
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'valor' => 'required|numeric|min:0',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'observacoes' => 'nullable|string',
        ]);

        $dataInicio = Carbon::parse($request->data_hora_inicio);
        $dataFim = Carbon::parse($request->data_hora_fim);

        if ($dataInicio < now() || $dataFim < now()) {
            return back()->with('error', 'A consulta deve ser no futuro.');
        }

        /*
        |----------------------------------------------------------------------
        | Validação de pertencimento
        |----------------------------------------------------------------------
        */

        $medico = Medico::where('id', $request->medico_id)
            ->where('clinica_id', $clinicaId)
            ->first();

        $paciente = Paciente::where('id', $request->paciente_id)
            ->where('clinica_id', $clinicaId)
            ->first();

        if (!$medico || !$paciente) {
            return back()->with('error', 'Dados inválidos para esta clínica.');
        }

        /*
        |----------------------------------------------------------------------
        | Convênio
        |----------------------------------------------------------------------
        */

        $desconto = 0;

        if ($request->convenio_id) {
            $convenio = Convenio::where('id', $request->convenio_id)
                ->where('clinica_id', $clinicaId)
                ->first();

            if (!$convenio) {
                return back()->with('error', 'Convênio inválido.');
            }

            $desconto = $convenio->percentual_desconto;
        }

        $valorFinal = $request->valor * (1 - $desconto / 100);

        /*
        |----------------------------------------------------------------------
        | Horário do médico
        |----------------------------------------------------------------------
        */

        if (
            $dataInicio->format('H:i') < $medico->horario_inicio ||
            $dataFim->format('H:i') > $medico->horario_fim
        ) {
            return back()->with('error', 'Fora do horário do médico.');
        }

        /*
        |----------------------------------------------------------------------
        | Conflito médico
        |----------------------------------------------------------------------
        */

        $conflitoMedico = Consulta::where('medico_id', $medico->id)
            ->where('clinica_id', $clinicaId)
            ->where('id', '!=', $consulta->id)
            ->where(function ($q) use ($dataInicio, $dataFim) {
                $q->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                    $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                });
            })
            ->exists();

        if ($conflitoMedico) {
            return back()->with('error', 'Médico já possui consulta nesse horário.');
        }

        /*
        |----------------------------------------------------------------------
        | Conflito paciente
        |----------------------------------------------------------------------
        */

        $conflitoPaciente = Consulta::where('paciente_id', $paciente->id)
            ->where('clinica_id', $clinicaId)
            ->where('id', '!=', $consulta->id)
            ->where(function ($q) use ($dataInicio, $dataFim) {
                $q->whereBetween('data_hora_inicio', [$dataInicio, $dataFim])
                ->orWhereBetween('data_hora_fim', [$dataInicio, $dataFim])
                ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                    $q->where('data_hora_inicio', '<=', $dataInicio)
                        ->where('data_hora_fim', '>=', $dataFim);
                });
            })
            ->exists();

        if ($conflitoPaciente) {
            return back()->with('error', 'Paciente já possui consulta nesse horário.');
        }

        /*
        |----------------------------------------------------------------------
        | Update seguro
        |----------------------------------------------------------------------
        */

        $consulta->update([
            'data_hora_inicio' => $dataInicio,
            'data_hora_fim' => $dataFim,
            'valor' => $valorFinal,
            'medico_id' => $medico->id,
            'paciente_id' => $paciente->id,
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

        $consulta = Consulta::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();

        $consulta->delete();

        return redirect()->route('consultas.list')
            ->with('success', 'Consulta cancelada com sucesso.');

    }

}