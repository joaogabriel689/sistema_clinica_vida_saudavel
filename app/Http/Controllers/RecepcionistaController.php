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
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }   
        $recepcionistas = User::where('role', 'recepcionista')->get();
        return view('recepcionista.index', compact('recepcionistas'));
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
        
        return view('recepcionista.create');
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        $recepcionista = User::findOrFail($id);
        return view('recepcionista.show', compact('recepcionista'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }   
        $recepcionista = User::findOrFail($id);
        return view('recepcionista.edit', compact('recepcionista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        } 
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }   
        $recepcionista = User::findOrFail($id);
        $recepcionista->delete();
        return redirect()->route('admin.recepcionistas')->with('success', 'Recepcionista excluído com sucesso.');
    }
}
