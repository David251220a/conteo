<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\PadronController;
use App\Http\Controllers\ReferenteController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [InicioController::class, 'index']);

Route::get('/logout', [LoginController::class, 'logout']);
Auth::routes();

Route::group([
    'middleware' => 'auth',
], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/referente', [ReferenteController::class, 'index'])->name('referente.index');
    Route::get('/referente/crear', [ReferenteController::class, 'create'])->name('referente.create');
    Route::post('/referente/crear', [ReferenteController::class, 'store'])->name('referente.store');
    Route::get('/referente/{referente}/crear', [ReferenteController::class, 'edit'])->name('referente.edit');
    Route::post('/referente/{referente}/crear', [ReferenteController::class, 'update'])->name('referente.update');

    Route::get('/local', [LocalController::class, 'index'])->name('local.index');
    Route::get('/local/crear', [LocalController::class, 'create'])->name('local.create');
    Route::post('/local/crear', [LocalController::class, 'store'])->name('local.store');
    Route::get('/local/{local}/crear', [LocalController::class, 'edit'])->name('local.edit');
    Route::post('/local/{local}/crear', [LocalController::class, 'update'])->name('local.update');

    Route::get('/vehiculo', [VehiculoController::class, 'index'])->name('vehiculo.index');
    Route::get('/vehiculo/crear', [VehiculoController::class, 'create'])->name('vehiculo.create');
    Route::post('/vehiculo/crear', [VehiculoController::class, 'store'])->name('vehiculo.store');
    Route::get('/vehiculo/{vehiculo}/crear', [VehiculoController::class, 'edit'])->name('vehiculo.edit');
    Route::post('/vehiculo/{vehiculo}/crear', [VehiculoController::class, 'update'])->name('vehiculo.update');
    Route::post('/vehiculo/{vehiculo}/agregar-local', [VehiculoController::class, 'agregar_local'])->name('vehiculo.agregar_local');
    Route::post('/vehiculo/{VehiculoLocal}/eliminar-local', [VehiculoController::class, 'eliminar_local'])->name('vehiculo.eliminar_local');
    Route::post('/vehiculo/{vehiculo}/pagar', [VehiculoController::class, 'pagar'])->name('vehiculo.pagar');

    Route::get('/padron', [PadronController::class, 'index'])->name('padron.index');

    Route::get('/consulta', [ConsultaController::class, 'referente'])->name('consulta.referente');
    Route::get('/consulta/referentes-por-local/{localId}', [ConsultaController::class, 'referentesPorLocal'])->name('consulta.referentes.local');

    Route::get('/lista', [ListaController::class, 'index'])->name('lista.index');
    Route::get('/lista/crear', [ListaController::class, 'create'])->name('lista.create');
    Route::post('/lista/crear', [ListaController::class, 'store'])->name('lista.store');
    Route::get('/lista/{lista}/editar', [ListaController::class, 'edit'])->name('lista.edit');
    Route::post('/lista/{lista}/editar', [ListaController::class, 'update'])->name('lista.update');

    Route::get('/candidato', [CandidatoController::class, 'index'])->name('candidato.index');
    Route::get('/candidato/crear', [CandidatoController::class, 'create'])->name('candidato.create');
    Route::post('/candidato/crear', [CandidatoController::class, 'store'])->name('candidato.store');
    Route::get('/candidato/{candidato}/editar', [CandidatoController::class, 'edit'])->name('candidato.edit');
    Route::post('/candidato/{candidato}/editar', [CandidatoController::class, 'update'])->name('candidato.update');

});


