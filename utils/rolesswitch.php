<?php
 use Illuminate\Support\Facades\Auth;
function switchRole() {
    switch (Auth::user()->role) {
        case 'admin':
            return redirect()->intended('admin')->with('success', 'Bem-vindo de volta, Admin!');
        case 'paciente':
            return redirect()->intended('pacientes')->with('success', 'Bem-vindo de volta!');
        case 'recepcao':
            return redirect()->intended('recepcao')->with('success', 'Bem-vindo de volta!');
        default:
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Função de usuário desconhecida.']);
    }
    
}