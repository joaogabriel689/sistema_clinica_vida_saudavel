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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (!Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }
        $clinica = null;
        
        $clinica = Clinica::where('user_id', Auth::id())->first();
        $quantidade_convenios = Clinica::where('user_id', Auth::id())->withCount('convenios')->first()->convenios_count;
        $quantidade_recepcionistas = User::where('role', 'recepcionista')->count();
        $quantidade_medicos = User::where('role', 'medico')->count();
        
    
        return view('admin.index', compact(['clinica', 'quantidade_convenios', 'quantidade_recepcionistas', 'quantidade_medicos']));
    }

    public function list_pacientes()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }

        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }


    public function criar_clinica()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }
        if (Clinica::where('user_id', Auth::id())->exists()) {
            return redirect()->route('me')->with('error', 'Você já possui uma clínica cadastrada.');
        }
        return view('admin.criar_clinica');
    }

    public function store_clinica(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }

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
