<?php

namespace App\Http\Controllers;
use App\Models\Convenio;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConvenioRequest;

use function Symfony\Component\Translation\t;

class ConveniosController extends Controller
{
    public function index(Request $request)
    {

        try{
            $query = Convenio::query()->where('clinica_id', Auth::user()->resolveClinicaId());

            if ($request->search) {
                $query->where('nome', 'like', '%' . $request->search . '%');
            }

            $convenios = $query->paginate(10);
        } catch (\Exception $e) {
            return redirect()->route('dashboard_split')->with('error', 'Erro ao carregar convênios: ' . $e->getMessage());
        }

        return view('convenios.index', compact('convenios'));
    }
    public function create()
    {


        return view('convenios.create');
    }
    public function store(StoreConvenioRequest $request)
    {
        $id_clinica = Auth::user()->resolveClinicaId();

        Convenio::create([
            'nome' => $request->nome,
            'clinica_id' => $id_clinica,
            'codigo' => $request->codigo,
            'percentual_desconto' => $request->percentual_desconto,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio criado com sucesso!');
    }

    public function destroy($id)
    {
        $convenio = Convenio::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();
        $convenio->delete();

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio excluído com sucesso!');
    }

    public function edit($id)
    {
        $convenio = Convenio::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();
        return view('convenios.edit', compact('convenio'));
    }
    
    public function update(StoreConvenioRequest $request, $id)
    {
        if (Convenio::where('codigo', $request->codigo)->where('clinica_id', Auth::user()->resolveClinicaId())->where('id', '!=', $id)->exists()) {
            return redirect()->route('admin.convenios.index')->with('error', 'Código já cadastrado');
        }

        $convenio = Convenio::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();

        $convenio->update([
            'nome' => $request->nome,
            'codigo' => $request->codigo,
            'percentual_desconto' => $request->percentual_desconto,
        ]);

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio atualizado com sucesso!');
    }
}
