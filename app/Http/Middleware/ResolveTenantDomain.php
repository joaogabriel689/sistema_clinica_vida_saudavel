<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Clinica;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenantDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost';

        // Se o Host atual for diferente do domínio principal do SaaS
        if ($host !== $mainDomain && $host !== '127.0.0.1') {
            $clinica = Clinica::where('custom_domain', $host)
                ->orWhere('slug', explode('.', $host)[0])
                ->first();

            if ($clinica) {
                // Guarda a clínica resolvida no request para acesso simplificado
                $request->attributes->set('tenant_clinica', $clinica);
            }
        }

        return $next($request);
    }
}
