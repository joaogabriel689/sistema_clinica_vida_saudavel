<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Clinica;

class AdminController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        return view('admin.index');
    }

    public function list_pacientes()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        // Aqui você pode buscar os pacientes do banco de dados e passá-los para a view
        // $pacientes = Paciente::all();
        // return view('admin.pacientes', compact('pacientes'));
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }


    public function criar_clinica()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
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
