<?php

namespace App\Http\Controllers;
use App\Models\Convenio;
use App\Models\Clinica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConveniosController extends Controller
{
    public function index(Request $request)
    {


        $query = Convenio::query()->where('clinica_id', Auth::user()->clinica_id);

        if ($request->search) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        $convenios = $query->paginate(10);

        return view('convenios.index', compact('convenios'));
    }
    public function create()
    {


        return view('convenios.create');
    }
    public function store(Request $request)
    {



        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'codigo' => 'required|string|max:255|unique:convenios,codigo',
            'percentual_desconto' => 'required|numeric|min:0|max:100',
        ]);
        $id_clinica = Clinica::where('user_id', Auth::id())->first()->id;

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


        $convenio = Convenio::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        $convenio->delete();

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio excluído com sucesso!');


    }

    public function edit($id)
    {


        $convenio = Convenio::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();
        return view('convenios.edit', compact('convenio'));


    }

    public function update(Request $request, $id)
    {


        $convenio = Convenio::findOrFail($id)->where('clinica_id', Auth::user()->clinica_id)->firstOrFail();

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'codigo' => 'required|string|max:255|unique:convenios,codigo,',
            'percentual_desconto' => 'required|numeric|min:0|max:100',
        ]);

        $convenio->update([
            'nome' => $request->nome,
            'codigo' => $request->codigo,
            'percentual_desconto' => $request->percentual_desconto,
        ]);

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio atualizado com sucesso!');
    }
}
