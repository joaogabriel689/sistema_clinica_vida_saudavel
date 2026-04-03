<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConveniosController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ConsultaController;

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');
// Route::middleware('throttle:10,1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/store_login', 'store_login')->name('auth-login');

        Route::get('/register', 'register')->name('register');
        Route::post('/store_register', 'store_register')->name('auth-register');
    });
// });
/*
|--------------------------------------------------------------------------
| Rotas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/medicos', [MedicoController::class, 'index'])->name('admin.medicos');
    /*
    |--------------------------------------------------------------------------
    | Auth interno
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::get('/dashboard_split', [AuthController::class, 'split'])->name('dashboard_split');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('role:admin')
        ->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('admin.index');


            Route::get('/criar_clinica', [AdminController::class, 'criar_clinica'])->name('admin.criar_clinica');
            Route::post('/store_clinica', [AdminController::class, 'store_clinica'])->name('admin.store_clinica');

            /*
            |---------------- RECEPCIONISTAS ----------------|
            */

            Route::prefix('recepcionistas')->group(function () {

                Route::get('/', [RecepcionistaController::class, 'index'])->name('admin.recepcionistas');
                Route::get('/create', [RecepcionistaController::class, 'create'])->name('admin.recepcionistas.create');
                Route::post('/', [RecepcionistaController::class, 'store'])->name('admin.recepcionistas.store');

                Route::get('/{id}', [RecepcionistaController::class, 'show'])->name('admin.recepcionistas.show');
                Route::get('/{id}/edit', [RecepcionistaController::class, 'edit'])->name('admin.recepcionistas.edit');

                Route::put('/{id}', [RecepcionistaController::class, 'update'])->name('admin.recepcionistas.update');
                Route::delete('/{id}', [RecepcionistaController::class, 'destroy'])->name('admin.recepcionistas.destroy');
            });

            /*
            |---------------- MÉDICOS ----------------|
            */

            Route::prefix('medicos')->group(function () {


                Route::get('/create', [MedicoController::class, 'create'])->name('admin.medicos.create');
                Route::post('/', [MedicoController::class, 'store'])->name('admin.medicos.store');

                Route::get('/{id}', [MedicoController::class, 'show'])->name('admin.medicos.show');
                Route::get('/{id}/edit', [MedicoController::class, 'edit'])->name('admin.medicos.edit');

                Route::put('/{id}', [MedicoController::class, 'update'])->name('admin.medicos.update');
                Route::delete('/{id}', [MedicoController::class, 'destroy'])->name('admin.medicos.destroy');
            });

            /*
            |---------------- CONVÊNIOS ----------------|
            */

            Route::prefix('convenios')->group(function () {

                Route::get('/', [ConveniosController::class, 'index'])->name('admin.convenios.index');
                Route::get('/create', [ConveniosController::class, 'create'])->name('admin.convenios.create');
                Route::post('/', [ConveniosController::class, 'store'])->name('admin.convenios.store');

                Route::get('/{id}/edit', [ConveniosController::class, 'edit'])->name('admin.convenios.edit');

                Route::put('/{id}', [ConveniosController::class, 'update'])->name('admin.convenios.update');
                Route::delete('/{id}', [ConveniosController::class, 'destroy'])->name('admin.convenios.destroy');
            });

        });

    /*
    |--------------------------------------------------------------------------
    | MÉDICO
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:medico')->group(function () {
        Route::get('/medicos/dashboard', [MedicoController::class, 'dashboard'])->name('medicos.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | RECEPCIONISTA
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:recepcionista')->group(function () {

        Route::get('/recepcionista', [RecepcionistaController::class, 'dashboard'])->name('recepcionista.dashboard');

        /*
        |---------------- PACIENTES ----------------|
        */

        Route::prefix('pacientes')->group(function () {
            Route::get('/pacientes', [AdminController::class, 'list_pacientes'])->name('admin.pacientes');

            Route::get('/create', [PacientesController::class, 'create'])->name('pacientes.create');
            Route::post('/', [PacientesController::class, 'store'])->name('pacientes.store');

            Route::get('/{id}', [PacientesController::class, 'show'])->name('pacientes.show');
            Route::get('/{id}/edit', [PacientesController::class, 'edit'])->name('pacientes.edit');

            Route::put('/{id}', [PacientesController::class, 'update'])->name('pacientes.update');
            Route::delete('/{id}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');
        });

        /*
        |---------------- CONSULTAS ----------------|
        */

        Route::prefix('consultas')->group(function () {

            Route::get('/', [ConsultaController::class, 'list'])->name('consultas.list');
            Route::get('/create', [ConsultaController::class, 'create'])->name('consultas.create');

            Route::post('/', [ConsultaController::class, 'store'])->name('consultas.store');

            Route::get('/{id}', [ConsultaController::class, 'show'])->name('consultas.show');
            Route::get('/{id}/edit', [ConsultaController::class, 'edit'])->name('consultas.edit');

            Route::put('/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
            Route::put('/{id}/pagar', [ConsultaController::class, 'confirmarPagamento'])->name('consultas.confirmar_pagamento');
            Route::put('/{id}/status', [ConsultaController::class, 'alterarStatus'])->name('consultas.alterar_status');
            Route::delete('/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
        });
    });

});

/*
|--------------------------------------------------------------------------
| API interna
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    Route::get('/medicos/{especialidade}', [MedicoController::class, 'porEspecialidade']);
    Route::get('/medico/{id}/horarios', [MedicoController::class, 'horarios']);
});