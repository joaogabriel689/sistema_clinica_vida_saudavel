<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\User;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedicoController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $medicos = Medico::all();
        return view('medicos.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $especialidades = Especialidade::all();
        return view('medicos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'crm' => 'required|string|max:255|unique:medicos,crm',
            'especialidade' => 'required',
            'nova_especialidade' => 'required_if:especialidade,outra',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            // Criar usuário
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'medico',
            ]);

            // Definir especialidade
            if ($request->especialidade === 'outra') {

                $especialidade = Especialidade::firstOrCreate([
                    'nome' => $request->nova_especialidade
                ]);

                $especialidadeId = $especialidade->id;

            } else {
                $especialidadeId = $request->especialidade;
            }

            // Criar médico
            Medico::create([
                'nome' => $request->nome,
                'crm' => $request->crm,
                'especialidade_id' => $especialidadeId,
                'telefone' => $request->telefone,
                'user_id' => $user->id,
                'clinica_id' => Auth::user()->clinica_id ?? 1, // ajuste conforme sua estrutura
                'horario_inicio' => $request->hora_inicio,
                'horario_fim' => $request->hora_fim,
            ]);
        });

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico criado com sucesso.');
    }


    public function edit(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $medico = Medico::findOrFail($id);
        $especialidades = Especialidade::all();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
