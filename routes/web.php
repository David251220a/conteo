<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\GrupoUsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LimpiarController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\PadronController;
use App\Http\Controllers\ReferenteController;
use App\Http\Controllers\SimuladorController;
use App\Http\Controllers\UrnaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VotoController;
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

// Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('/cesar-mendez', [InicioController::class, 'cesar'])->name('cesar');
Route::get('/dani-vezquez', [InicioController::class, 'dani'])->name('dani');
Route::get('/lic-giselle-paredes', [InicioController::class, 'giselle'])->name('giselle');
Route::get('/roberto-martinez', [InicioController::class, 'roberto'])->name('roberto');
Route::get('/esmilse-bobadilla', [InicioController::class, 'esmilse'])->name('esmilse');
Route::get('/diosnel-fernoli', [InicioController::class, 'diosnel'])->name('diosnel');
Route::get('/liza-ruiz-diaz', [InicioController::class, 'liza'])->name('liza');
Route::get('/carlos-acosta', [InicioController::class, 'carlos'])->name('carlos');
Route::get('/julio-diaz', [InicioController::class, 'julio'])->name('julio');
Route::get('/joel-gomez', [InicioController::class, 'joel'])->name('joel');
Route::get('/oliver-rivas', [InicioController::class, 'oliver'])->name('oliver');
Route::get('/adolfo-paredes', [InicioController::class, 'adolfo'])->name('adolfo');
Route::get('/limpiar', [LimpiarController::class, 'limpiar'])->name('limpiar');


Route::get('/carlos-britez', [InicioController::class, 'benito'])->name('benito');
Route::get('/humberto-zorrilla', [InicioController::class, 'humberto'])->name('humberto');
Route::get('/juan-duarte', [InicioController::class, 'juan'])->name('juan');
Route::get('/gabriela-godoy', [InicioController::class, 'gabriela'])->name('gabriela');
Route::get('/diego-britez', [InicioController::class, 'diego'])->name('diego');
Route::get('/miguel-pando', [InicioController::class, 'miguel'])->name('miguel');
Route::get('/carlos-espinola', [InicioController::class, 'espinola'])->name('espinola');
Route::get('/ofelia-diaz', [InicioController::class, 'ofelia'])->name('ofelia');
Route::get('/gilberto-zarate', [InicioController::class, 'gilberto'])->name('gilberto');
Route::get('/ernesto-pereira', [InicioController::class, 'ernesto'])->name('ernesto');
Route::get('/maria-gimenez', [InicioController::class, 'maria'])->name('maria');
Route::get('/juan-cuevas', [InicioController::class, 'humberto'])->name('cuevas');


Route::get('/simulacion', [InicioController::class, 'simulacion'])->name('simulacion');

Route::get('/logout', [LoginController::class, 'logout']);
Auth::routes();

Route::group([
    'middleware' => 'auth',
], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/users', UsuarioController::class)->names('user');
    Route::resource('/roles', GrupoUsuarioController::class)->names('role');
    Route::get('/permiso-crear', [GrupoUsuarioController::class, 'permiso_crear'])->name('role.permiso_crear');
    Route::post('/permiso-crear', [GrupoUsuarioController::class, 'permiso_crear_post'])->name('role.permiso_crear_post');

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
    Route::post('/local/{local}/generar-mesas', [LocalController::class, 'generar_mesas'])->name('local.generar_mesas');

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
    Route::get('/consulta/simulacion', [SimuladorController::class, 'simulacion'])->name('consulta.simulacion');
    Route::get('/consulta/simulacion/{fecha}/ver', [SimuladorController::class, 'simulacion_ver'])->name('consulta.simulacion_ver');

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

    Route::get('/voto-manual/intendente', [VotoController::class, 'intendente_manual'])->name('voto.intendente_manual');
    Route::get('/voto-manual/consejal-cargar', [VotoController::class, 'consejal_manual'])->name('voto.consejal_manual');
    Route::get('/voto-importar/consejal-cargar', [VotoController::class, 'consejal_import'])->name('voto.consejal_import');
    Route::get('/voto/consulta-votos', [VotoController::class, 'consulta_votos_carga'])->name('voto.consulta_votos_carga');
    Route::get('/voto/consulta-lista', [VotoController::class, 'consulta_lista'])->name('voto.consulta_lista');
    Route::get('/voto/reporte', [VotoController::class, 'reporte'])->name('voto.reporte');
    Route::get('/voto/dhondt', [VotoController::class, 'dhondt'])->name('voto.dhondt');
    Route::get('/voto/dhondt/reporte', [VotoController::class, 'reporte_dhondt_concejales'])->name('voto.reporte_dhondt_concejales');
    Route::get('/voto/{localMesa}/consulta-votos/pdf', [VotoController::class, 'consulta_pdf'])->name('voto.consulta_pdf');
    Route::get('/voto/{local_mesa}/anular', [VotoController::class, 'anular_carga_voto'])->name('voto.anular_carga_voto');
    Route::get('/voto/{local_mesa_id}/{tipo_candidato_id}/impresion-votos', [VotoController::class, 'impresion_acta'])->name('voto.impresion_acta');

    Route::get('/sondeo', [UrnaController::class, 'index'])->name('sondeo.index');
    Route::get('/sondeo/show', [UrnaController::class, 'show'])->name('sondeo.show');


});


