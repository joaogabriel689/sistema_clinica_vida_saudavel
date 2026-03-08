<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConveniosController;
use App\Http\Controllers\ConsultaController;


Route::get('/', function () {
    return view('welcome');
})->name('index');


Route::get('/me', [AuthController::class, 'me'])->name('me');
# Rotas de autenticação

Route::get('/dashboard_split', [AuthController::class, 'split'])->name('dashboard_split');


Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/store_register', [AuthController::class, 'store_register'])->name('auth-register');

route::get('/login', [AuthController::class, 'login'])->name('login');

route::post('/store_login', [AuthController::class, 'store_login'])->name('auth-login');

route::post('/logout', [AuthController::class, 'logout'])->name('logout');


#rotas de admin

route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

route::get('/admin/pacientes', [AdminController::class, 'list_pacientes'])->name('admin.pacientes');

route::get("/admin/recepcionistas", [RecepcionistaController::class, 'index'])->name('admin.recepcionistas');

route::get("/admin/recepcionistas/create", [RecepcionistaController::class, 'create'])->name('admin.recepcionistas.create');
route::post("/admin/recepcionistas", [RecepcionistaController::class, 'store'])->name('admin.recepcionistas.store');

route::get("/admin/recepcionistas/{id}", [RecepcionistaController::class, 'show'])->name('admin.recepcionistas.show');


route::get("/admin/recepcionistas/{id}/edit", [RecepcionistaController::class, 'edit'])->name('admin.recepcionistas.edit');

route::put("/admin/recepcionistas/{id}", [RecepcionistaController::class, 'update'])->name('admin.recepcionistas.update');

route::delete("/admin/recepcionistas/{id}", [RecepcionistaController::class, 'destroy'])->name('admin.recepcionistas.destroy');

route::get('/admin/medicos', [MedicoController::class, 'index'])->name('admin.medicos');
route::get('/admin/medicos/create', [MedicoController::class, 'create'])->name('admin.medicos.create');
route::post('/admin/medicos', [MedicoController::class, 'store'])->name('admin.medicos.store');
route::get('/admin/medicos/{id}', [MedicoController::class, 'show'])->name('admin.medicos.show');
route::get('/admin/medicos/{id}/edit', [MedicoController::class, 'edit'])->name('admin.medicos.edit');
route::put('/admin/medicos/{id}', [MedicoController::class, 'update'])->name('admin.medicos.update');
route::delete('/admin/medicos/{id}', [MedicoController::class, 'destroy'])->name('admin.medicos.destroy');

route::get('/admin/criar_clinica', [AdminController::class, 'criar_clinica'])->name('admin.criar_clinica');
route::post('/admin/store_clinica', [AdminController::class, 'store_clinica'])->name('admin.store_clinica');

#rotas para convenio

Route::get('/admin/convenios', [ConveniosController::class, 'index'])->name('admin.convenios.index');
Route::get('/admin/convenios/create', [ConveniosController::class, 'create'])->name('admin.convenios.create');
Route::post('/admin/convenios', [ConveniosController::class, 'store'])->name('admin.convenios.store');
Route::get('/admin/convenios/{id}/edit', [ConveniosController::class, 'edit'])->name('admin.convenios.edit');
Route::put('/admin/convenios/{id}', [ConveniosController::class, 'update'])->name('admin.convenios.update');
Route::delete('/admin/convenios/{id}', [ConveniosController::class, 'destroy'])->name('admin.convenios.destroy');

#rotas para medico

route::get('/medicos/dashboard', [MedicoController::class, 'dashboard'])->name('medicos.dashboard');

Route::get('/api/medicos/{especialidade}', [MedicoController::class, 'porEspecialidade']);
Route::get('/api/medico/{id}/horarios', [MedicoController::class, 'horarios']);

#rotas para recepcionista

route::get('/recepcionista', [RecepcionistaController::class, 'dashboard'])->name('recepcionista.dashboard');



#grupo de rotas para pacientes


Route::get('/pacientes/create', [PacientesController::class, 'create'])->name('pacientes.create');

Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');

Route::get('/pacientes/{id}', [PacientesController::class, 'show'])->name('pacientes.show');

Route::get('/pacientes/{id}/edit', [PacientesController::class, 'edit'])->name('pacientes.edit');

Route::put('/pacientes/{id}', [PacientesController::class, 'update'])->name('pacientes.update');

Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

#rotas para consultas

Route::get('/consultas', [ConsultaController::class, 'list'])->name('consultas.list');

Route::get('/consultas/create', [ConsultaController::class, 'create'])->name('consultas.create');

route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');

route::get('/consultas/{id}', [ConsultaController::class, 'show'])->name('consultas.show');

route::get('/consultas/{id}/edit', [ConsultaController::class, 'edit'])->name('consultas.edit');

route::put('/consultas/{id}', [ConsultaController::class, 'update'])->name('consultas.update');

route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');

