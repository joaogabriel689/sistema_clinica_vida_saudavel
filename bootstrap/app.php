<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 🔹 Exceções de Validação CSRF para Webhooks Externos (Asaas, Evolution API)
        $middleware->validateCsrfTokens(except: [
            'api/webhooks/*',
            'api/v1/*',
        ]);

        // 🔹 Alias
        $middleware->alias([
            'role'           => \App\Http\Middleware\RoleMiddleware::class,
            // 'auditoria'      => \App\Http\Middleware\AuditoriaMiddleware::class,
            'clinica.exists' => \App\Http\Middleware\EnsureClinicaExists::class,
        ]);



    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
            'cpf',
            'token',
            'secret',
            'credit_card'
        ]);
    })
    ->create();