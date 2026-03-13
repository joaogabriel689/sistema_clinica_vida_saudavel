<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Paciente;
use Illuminate\Support\Facades\Auth;
class PacientesController extends Controller
{
    // publicadmin. function()
    // {
    //     if(!Auth::check()) {
    //         return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
    //     }
    //     $pacientes = Paciente::all();
    //     return view('admin.pacientes', compact('pacientes'));
    // }

    public function create()
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:pacientes',
            'telefone' => 'required',
            'endereco' => 'required',
            'data_nascimento' => 'required|date',
        ]);

        Paciente::create($request->all());
        return redirect()->route('admin.pacientes')->with('success', 'Paciente criado com sucesso.');
    }

    public function show($id)
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $paciente = Paciente::with([
            'consultas.medico',
            'consultas.especialidade'
        ])->findOrFail($id);

        return view('pacientes.show', compact('paciente'));
    }

    public function edit($id)
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }
    public function update(Request $request, $id)
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:pacientes,cpf,',
            'telefone' => 'required',
            'endereco' => 'required',
            'data_nascimento' => 'required|date',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        return redirect()->route('admin.pacientes')->with('success', 'Paciente atualizado com sucesso.');
    }
    public function destroy($id)
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'recepcionista') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        return redirect()->route('admin.pacientes')->with('success', 'Paciente deletado com sucesso.');
    }

}
