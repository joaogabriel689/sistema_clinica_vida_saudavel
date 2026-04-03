<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Clinica;
use App\Http\Requests\StoreRecepcionistaRequest;
use App\Http\Requests\UpdateRecepcionistaRequest;
use App\Services\DashboardService;

class RecepcionistaController extends Controller
{
    protected DashboardService $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = User::where('role', 'recepcionista')->where('clinica_id', Clinica::where('user_id', Auth::id())->first()->id);

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
    public function store(StoreRecepcionistaRequest $request)
    {

  

        try {
            $id_clinica = Auth::user()->clinica_id;
        } catch (\Exception $e) {
            return redirect()->route('admin.recepcionistas')->with('error', 'Erro ao criar recepcionista: ' . $e->getMessage());
        }
        User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'recepcionista',
            'clinica_id' => $id_clinica,
        ]);
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista criado com sucesso.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $recepcionista = User::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        return view('recepcionista.show', compact('recepcionista'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $recepcionista = User::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        return view('recepcionista.edit', compact('recepcionista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecepcionistaRequest $request, string $id)
    {


        $recepcionista = User::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
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

        $recepcionista = User::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $recepcionista->delete();
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista excluído com sucesso.');
    }

    public function dashboard()
    {
        $dados = $this->dashboardService->recepcionistaDashboard();
        // Retorna a view com os dados
        return view('recepcionista.dashboard', $dados);
    }
}
