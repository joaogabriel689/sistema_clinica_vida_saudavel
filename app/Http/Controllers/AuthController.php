<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
            // No registro público, o ideal é definir um role padrão (ex: paciente ou recepcionista)
        ]);
        // No Laravel, precisamos criptografar a senha manualmente ao criar
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Igual ao set_password do Django
            'role' => $request->role ?? 'admin', // Define um padrão seguro
        ]);

        return redirect()->route('login')->with('success', 'Registro realizado com sucesso.');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }
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

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->intended('admin')->with('success', 'Bem-vindo de volta, ' . Auth::user()->name . '!');
                case 'paciente':
                    return redirect()->intended('pacientes')->with('success', 'Bem-vindo de volta!');
                case 'recepcionista':
                    return redirect()->intended('recepcionista')->with('success', 'Bem-vindo de volta!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Função de usuário desconhecida.']);
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
}