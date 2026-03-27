<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RecepcionistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = User::where('role', 'recepcionista');

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");

            });
        }

    $recepcionistas = $query->paginate(10);

    return view('recepcionista.index', compact('recepcionistas'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('recepcionista.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  
        $request->validate([
            'nome' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);
        
        User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'recepcionista',
        ]);
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista criado com sucesso.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $recepcionista = User::findOrFail($id);
        return view('recepcionista.show', compact('recepcionista'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $recepcionista = User::findOrFail($id);
        return view('recepcionista.edit', compact('recepcionista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nome' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ]);
        $recepcionista = User::findOrFail($id);
        $data = $request->all();
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $recepcionista->update($data);
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista atualizado com sucesso.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $recepcionista = User::findOrFail($id);
        $recepcionista->delete();
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista excluído com sucesso.');
    }

    public function dashboard()
    {


        // Quantidade total de pacientes cadastrados
        $quantidade_pacientes = \App\Models\Paciente::count();

        // Quantidade de médicos cadastrados
        $quantidade_medicos = \App\Models\Medico::count();

        // Quantidade de consultas marcadas para hoje
        $quantidade_consultas_hoje = \App\Models\Consulta::whereDate(
            'data_hora_inicio',
            now()->toDateString()
        )->count();

        // Últimos 5 pacientes cadastrados
        $pacientes_recentes = \App\Models\Paciente::latest()
            ->take(5)
            ->get();

        // Consultas de hoje (com médico e paciente)
        $agendas_hoje = \App\Models\Consulta::with(['medico', 'paciente'])
            ->whereDate('data_hora_inicio', now()->toDateString())
            ->orderBy('data_hora_inicio')
            ->get();

        // Retorna a view com os dados
        return view('recepcionista.dashboard', compact(
            'quantidade_pacientes',
            'quantidade_consultas_hoje',
            'quantidade_medicos',
            'pacientes_recentes',
            'agendas_hoje'
        ));
    }
}
