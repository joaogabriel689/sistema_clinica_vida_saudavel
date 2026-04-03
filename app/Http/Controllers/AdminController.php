<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Clinica;
use App\Models\User;
use App\Http\Requests\StoreClinicaRequest;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        try {
            $dados = $this->dashboardService->adminDashboard();
        } catch (\Exception $e) {

            Log::error('Erro no dashboard admin', [
                'erro' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->route('me')
                ->with('error', 'Erro ao carregar dashboard');
        }

        return view('admin.index', $dados);
    }
    public function list_pacientes()
    {
        try{
            $pacientes = Paciente::all()->where('clinica_id', Auth::user()->clinica_id);
        } catch (\Exception $e) {
            return redirect()->route('dashboard_split')->with('error', 'Erro ao carregar dados dos pacientes: ' . $e->getMessage());
        }
        return view('pacientes.index', compact('pacientes'));
    }


    public function criar_clinica()
    {

        return view('admin.criar_clinica');
    }

    public function store_clinica(StoreClinicaRequest $request)
    {

        try{
            Clinica::create([
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'telefone' => $request->telefone,
                'cnpj' => $request->cnpj,
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.criar_clinica')->with('error', 'Erro ao criar clínica: ' . $e->getMessage());
        }



        return redirect()->route('admin.index')->with('success', 'Clínica criada com sucesso.');
    }





}
