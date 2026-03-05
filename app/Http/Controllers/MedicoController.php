<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\User;
use App\Models\Especialidade;
use App\Models\Clinica;
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
        // Verifica se o usuário está logado
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        // Verifica se o usuário é admin
        if (Auth::user()->role !== 'admin') {
            return redirect()
                ->route('index')
                ->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Validação dos dados enviados pelo formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'crm' => 'required|string|max:255|unique:medicos,crm',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string',
            'especialidade' => 'required',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);

        // Transação para garantir que tudo seja salvo ou nada seja salvo
        DB::transaction(function () use ($request) {

            // Cria o usuário do médico
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'medico',
            ]);

            // Verifica se o usuário selecionou "Outra especialidade"
            if ($request->especialidade === 'outra') {

                // Cria ou encontra a especialidade
                $especialidade = Especialidade::firstOrCreate([
                    'nome' => $request->nova_especialidade
                ]);

                $especialidadeId = $especialidade->id;

            } else {

                // Usa a especialidade selecionada
                $especialidadeId = $request->especialidade;
            }

            // Cria o médico
            Medico::create([
                'nome' => $request->nome,
                'crm' => $request->crm,
                'especialidade_id' => $especialidadeId,
                'telefone' => $request->telefone,
                'user_id' => $user->id,
                'clinica_id' => Clinica::where('user_id', Auth::id())->first()->id ?? null,
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
    public function update(Request $request, $id)
    {
        // Verifica se o usuário está logado
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Você precisa estar logado.');
        }

        // Verifica se é admin
        if (Auth::user()->role !== 'admin') {
            return redirect()
                ->route('index')
                ->with('error', 'Acesso negado.');
        }

        // Busca o médico
        $medico = Medico::findOrFail($id);

        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'crm' => 'required|string|max:255|unique:medicos,crm,' . $medico->id,
            'email' => 'required|email|max:255|unique:users,email,' . $medico->user_id,
            'especialidade' => 'required',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);

        // Transaction para garantir integridade
        DB::transaction(function () use ($request, $medico) {

            // Atualiza o email do usuário relacionado ao médico
            $user = User::find($medico->user_id);

            $user->update([
                'name' => $request->nome,
                'email' => $request->email
            ]);

            // Verifica se selecionou "outra especialidade"
            if ($request->especialidade === 'outra') {

                $especialidade = Especialidade::firstOrCreate([
                    'nome' => $request->nova_especialidade
                ]);

                $especialidadeId = $especialidade->id;

            } else {

                $especialidadeId = $request->especialidade;

            }

            // Atualiza os dados do médico
            $medico->update([
                'nome' => $request->nome,
                'crm' => $request->crm,
                'especialidade_id' => $especialidadeId,
                'horario_inicio' => $request->hora_inicio,
                'horario_fim' => $request->hora_fim,
            ]);

        });

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $medico = Medico::findOrFail($id);
        $user = User::find($medico->user_id);
        $medico->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.medicos')->with('success', 'Médico deletado com sucesso.');
    }
}
