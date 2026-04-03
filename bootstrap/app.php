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

        // 🔹 Alias
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'auditoria' => \App\Http\Middleware\AuditoriaMiddleware::class,
        ]);

        // 🔹 Adiciona global no grupo web
        $middleware->web(append: [
            \App\Http\Middleware\AuditoriaMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();