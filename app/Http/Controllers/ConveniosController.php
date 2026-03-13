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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $query = Convenio::query();

        if ($request->search) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        $convenios = $query->paginate(10);

        return view('convenios.index', compact('convenios'));
    }
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        return view('convenios.create');
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $clinica = Clinica::where('user_id', Auth::id())->first();
        if (!$clinica) {
            return redirect()->route('admin.index')->with('error', 'Você precisa criar uma clínica antes de adicionar convênios.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'codigo' => 'required|string|max:255|unique:convenios,codigo',
            'percentual_desconto' => 'required|numeric|min:0|max:100',
        ]);

        Convenio::create([
            'nome' => $request->nome,
            'clinica_id' => $clinica->id,
            'codigo' => $request->codigo,
            'percentual_desconto' => $request->percentual_desconto,
        ]);

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio criado com sucesso!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $convenio = Convenio::findOrFail($id);
        $convenio->delete();

        return redirect()->route('admin.convenios.index')->with('success', 'Convênio excluído com sucesso!');


    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $convenio = Convenio::findOrFail($id);
        return view('convenios.edit', compact('convenio'));


    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o painel de administração.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $convenio = Convenio::findOrFail($id);

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
