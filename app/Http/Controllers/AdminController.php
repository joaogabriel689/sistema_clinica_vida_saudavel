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
    public function criar_clinica()
    {
        return view('admin.criar_clinica');
    }
    public function store_clinica(StoreClinicaRequest $request)
    {
        $clinica = Clinica::create($request->validated());

        User::where('id', Auth::id())->update(['clinica_id' => $clinica->id]);

        return redirect()
              ->route('admin.index')
              ->with('success', 'Clínica criada e associada ao usuário com sucesso.');
    }

    








}
