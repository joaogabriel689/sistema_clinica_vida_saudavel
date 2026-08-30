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
        // try {
        //     $dados = $this->dashboardService->adminDashboard();
        // } catch (\Exception $e) {

        //     Log::error('Erro no dashboard admin', [
        //         'erro' => $e->getMessage(),
        //         'user_id' => Auth::id()
        //     ]);

        //     return redirect()
        //         ->route('me')
        //         ->with('error', 'Erro ao carregar dashboard');
        // }

        // return view('admin.index', $dados);
        return view('admin.index');
    }
    public function list_pacientes()
    {
        try {
            $pacientes = Paciente::where('clinica_id', Auth::user()->clinica_id)->get();
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
        $clinica = Clinica::create($request->validated());

        try {
            $clinica = Clinica::create([
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'telefone' => $request->telefone,
                'cnpj' => $request->cnpj,
                'user_id' => Auth::id(),
            ]);

            $user = Auth::user();
            $user->clinica_id = $clinica->id;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->route('admin.criar_clinica')->with('error', 'Erro ao criar clínica: ' . $e->getMessage());
        }

        return redirect()
              ->route('admin.index')
              ->with('success', 'Clínica criada e associada ao usuário com sucesso.');
    }

    public function update_clinica(Request $request)
    {
        $user = Auth::user();
        $clinicaId = $user->resolveClinicaId();
        $clinica = Clinica::findOrFail($clinicaId);

        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cnpj' => 'required|string|max:255',
            'custom_domain' => 'nullable|string|max:255|unique:clinicas,custom_domain,' . $clinica->id,
            'cor_primaria' => 'nullable|string|max:20',
            'logo_url' => 'nullable|string|max:500',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'banner_url' => 'nullable|string|max:500',
            'banner_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'descricao' => 'nullable|string|max:2000',
        ]);

        $disk = config('filesystems.default', 's3');
        $logoUrl = $request->logo_url;
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('logos', $disk);
            $logoUrl = \Illuminate\Support\Facades\Storage::disk($disk)->url($path);
        }

        $bannerUrl = $request->banner_url;
        if ($request->hasFile('banner_file')) {
            $path = $request->file('banner_file')->store('banners', $disk);
            $bannerUrl = \Illuminate\Support\Facades\Storage::disk($disk)->url($path);
        }

        $clinica->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'cnpj' => $request->cnpj,
            'custom_domain' => $request->custom_domain,
            'cor_primaria' => $request->cor_primaria ?? '#059669',
            'logo_url' => $logoUrl,
            'banner_url' => $bannerUrl,
            'descricao' => $request->descricao,
        ]);

        return redirect()->back()->with('success', 'Informações, imagens (S3) e personalização da clínica atualizadas com sucesso!');
    }
}
