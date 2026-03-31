<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Clinica;
use App\Models\User;
use App\Http\Requests\StoreClinicaRequest;

class AdminController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $clinica = Clinica::where('user_id', $user->id)->first();

        // Evita erro se não tiver clínica
        if (!$clinica) {
            return view('admin.index', [
                'clinica' => null,
                'quantidade_convenios' => 0,
                'quantidade_recepcionistas' => 0,
                'quantidade_medicos' => 0,
                'consultas_hoje' => 0,
                'consultas_mes' => 0,
                'faturamento_mes' => 0,
                'novos_pacientes_mes' => 0,
                'ticket_medio' => 0,
            ]);
        }

        // Datas
        $hoje = now();
        $mes = $hoje->month;
        $ano = $hoje->year;

        // Relacionamentos
        $consultas = $clinica->consultas();
        $pacientes = $clinica->pacientes();

        // Contagens
        $quantidade_convenios = $clinica->convenios()->count();

        $quantidade_recepcionistas = User::where('role', 'recepcionista')
            ->where('clinica_id', $clinica->id)
            ->count();

        $quantidade_medicos = User::where('role', 'medico')
            ->where('clinica_id', $clinica->id)
            ->count();

        $consultas_hoje = $consultas
            ->whereDate('data_hora_inicio', $hoje)
            ->count();

        // Clonar query pra não "sujar"
        $consultas_mes_query = $clinica->consultas()
            ->whereMonth('data_hora_inicio', $mes)
            ->whereYear('data_hora_inicio', $ano);

        $consultas_mes = $consultas_mes_query->count();

        $faturamento_mes = (clone $consultas_mes_query)->sum('valor');

        $novos_pacientes_mes = $pacientes
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->count();

        $ticket_medio = $consultas_mes > 0
            ? $faturamento_mes / $consultas_mes
            : 0;

        return view('admin.index', compact(
            'clinica',
            'quantidade_convenios',
            'quantidade_recepcionistas',
            'quantidade_medicos',
            'consultas_hoje',
            'consultas_mes',
            'faturamento_mes',
            'novos_pacientes_mes',
            'ticket_medio'
        ));
    }
    public function list_pacientes()
    {

        $pacientes = Paciente::all()->where('clinica_id', Auth::user()->clinica_id);
        return view('pacientes.index', compact('pacientes'));
    }


    public function criar_clinica()
    {

        return view('admin.criar_clinica');
    }

    public function store_clinica(StoreClinicaRequest $request)
    {



        Clinica::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'cnpj' => $request->cnpj,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.index')->with('success', 'Clínica criada com sucesso.');
    }





}
