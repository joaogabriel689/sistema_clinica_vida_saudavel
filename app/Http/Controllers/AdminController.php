<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Clinica;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;

class AdminController extends Controller
{

    public function index()
    {

        $clinica = null;
        $clinica_id = Auth::user()->clinica_id;
        $clinica = Clinica::where('user_id', Auth::id())->first();
        $quantidade_convenios = Clinica::where('user_id', Auth::id())->withCount('convenios')->first()?->convenios_count;
        $quantidade_recepcionistas = User::where('role', 'recepcionista')->where('clinica_id', $clinica->id ?? null)->count();
        $quantidade_medicos = User::where('role', 'medico')->where('clinica_id', $clinica->id ?? null)->count();
        
    
        return view('admin.index', compact(['clinica', 'quantidade_convenios', 'quantidade_recepcionistas', 'quantidade_medicos']));
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

    public function store_clinica(Request $request)
    {


        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'cnpj' => 'required|string|max:20|unique:clinicas',

        ]);
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
