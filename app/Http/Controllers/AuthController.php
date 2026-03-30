<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Medico;
use App\Models\Recepcionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Importante para a senha

class AuthController extends Controller // Corrigi o nome da classe para AuthController
{
    public function register()
    {
        return view('auth.register');
    }

    public function store_register(Request $request)
    {
        // 🔹 Validação única (mais limpo)
        $request->validate([
            // usuário
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:6',

            // clínica
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'cnpj' => 'required|string|max:20|unique:clinicas',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        $clinica = Clinica::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'cnpj' => $request->cnpj,
            'user_id' => $user->id,
        ]);


        $user->update([
            'clinica_id' => $clinica->id
        ]);


        Auth::login($user);


        return redirect()->route('admin.index')
            ->with('success', 'Conta criada com sucesso!');
    }

    public function login()
    {

        return view('auth.login');
    }

    public function store_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended(route('admin.index'))
                        ->with('success', 'Bem-vindo de volta, ' . $user->name . '!');

                case 'medico':
                    return redirect()->intended(route('medicos.dashboard'))
                        ->with('success', 'Bem-vindo de volta!');

                case 'recepcionista':
                    return redirect()->intended(route('recepcionista.dashboard'))
                        ->with('success', 'Bem-vindo de volta!');

                default:
                    Auth::logout();
                    return redirect()->route('login')
                        ->withErrors(['email' => 'Função de usuário desconhecida.']);
            }


        }

        return back()->withErrors([
            'email' => 'As credenciais não coincidem com nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function me()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Você precisa estar logado para acessar esta página.']);
        }
        $user = Auth::user();

        $clinica = null;
        $medico = null;
        $recepcionista = null;

        if ($user->role === 'admin') {
            $clinica = Clinica::where('user_id', $user->id)->first();
        }

        if ($user->role === 'medico') {
            $medico = Medico::where('user_id', $user->id)->with('especialidade')->first();
        }


        return view('auth.me', compact(
            'user',
            'clinica',
            'medico',
            
        ));
    }

    public function split()
    {
        if (Auth::check()) {
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.index');
                case 'medico':
                    return redirect()->route('medicos.dashboard');
                case 'recepcionista':
                    return redirect()->route('recepcionista.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Função de usuário desconhecida.']);
            }
        }
        return redirect()->route('login')->withErrors(['email' => 'Você precisa estar logado para acessar esta página.']);
    }
}