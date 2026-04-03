<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditoriaModel;
use Illuminate\Support\Facades\Auth;

class AuditoriaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $metodo = $this->mapAcao($request->method());

        if ($request->is('auditoria*')) {
            return $response; // Evita logar ações na própria auditoria
        }
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $next($request);
        }
        $rotasIgnoradas = [
            'api/medicos',
            'medico/*/horarios'
        ];

        foreach ($rotasIgnoradas as $rota) {
            if ($request->is($rota)) {
                return $response;
            }
        }
        if (Auth::check()) {

            AuditoriaModel::create([
                'user_id' => Auth::id(),
                'tipo_user' => Auth::user()->role ?? null,
                'acao' => $metodo,

                'rota' => $request->path(),
                'metodo' => $request->method(),

                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),

                'data_hora' => now(),
            ]);
        }

        return $response;
    }

    private function mapAcao($method)
    {
        return match($method) {
            'POST' => 'CREATE',
            'PUT', 'PATCH' => 'UPDATE',
            'DELETE' => 'DELETE',
            default => 'VIEW'
        };
    }
}