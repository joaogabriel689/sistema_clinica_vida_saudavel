<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureClinicaExists
{
    // Rotas que não devem ser interceptadas mesmo sem clínica
    private array $rotasIgnoradas = [
        'admin.criar_clinica',
        'logout',
        'me',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return $next($request);
        }
        foreach ($this->rotasIgnoradas as $rota) {
            if ($request->routeIs($rota)) {
                return $next($request);
            }
        }
        if (is_null(Auth::user()->clinica_id)) {
            return redirect()
                ->route('admin.criar_clinica')
                ->with('info', 'Complete o cadastro da sua clínica para continuar.');
        }

        return $next($request);
    }
}