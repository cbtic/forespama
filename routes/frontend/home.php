<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

use App\Http\Controllers\Frontend\IngresoVehiculoTroncoController;
use App\Http\Controllers\Frontend\TablaMaestraController;
use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\EmpresaController;
use App\Http\Controllers\Frontend\VehiculoController;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });

Route::get('ingreso_vehiculo_tronco', [IngresoVehiculoTroncoController::class, 'index'])->name('ingreso_vehiculo_tronco');

// Route::get('tabla_maestras', [TablaMaestraController::class, 'index'])->name('tabla_maestras.all');
// Route::get('tabla_maestras/{id}', [TablaMaestraController::class, 'show'])->name('tabla_maestras.show');
// Route::post('tabla_maestras/create', [TablaMaestraController::class, 'create'])->name('tabla_maestras.create');
// Route::post('tabla_maestras/send', [TablaMaestraController::class, 'send'])->name('tabla_maestras.send');
// Route::post('tabla_maestras/listar_tabla_maestras_ajax', [TablaMaestraController::class, 'listar_tabla_maestras_ajax'])->name('tabla_maestras.listar_tabla_maestras_ajax');
// Route::get('tabla_maestras/modal_tablamaestras/{id}', [TablaMaestraController::class, 'modal_tablamaestras'])->name('tabla_maestras.modal_tablamaestras');
// Route::get('tabla_maestras/eliminar_tabla_maestra/{id}/{estado}', [TablaMaestraController::class, 'eliminar_tabla_maestra'])->name('tabla_maestras.eliminar_tabla_maestra');

Route::get('personas', [personaController::class, 'index'])->name('personas');
Route::post('persona/send', [personaController::class, 'send'])->name('persona.send');
Route::get('persona/consulta_persona', [PersonaController::class, 'consulta_persona'])->name('persona.consulta_persona');
Route::post('persona/listar_persona_ajax', [PersonaController::class, 'listar_persona_ajax'])->name('persona.listar_persona_ajax');
Route::get('persona/modal_persona/{id}', [PersonaController::class, 'modal_persona'])->name('persona.modal_persona');
Route::get('persona/eliminar_persona/{id}/{estado}', [PersonaController::class, 'eliminar_persona'])->name('persona.eliminar_persona');
Route::post('persona/buscar_persona_ajax', [PersonaController::class, 'buscar_persona_ajax'])->name('persona.buscar_persona_ajax');

Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas');
Route::post('empresa/send', [EmpresaController::class, 'send'])->name('empresa.send');
Route::get('empresa/consulta_empresa', [EmpresaController::class, 'consulta_empresa'])->name('empresa.consulta_empresa');
Route::post('empresa/listar_empresa_ajax', [EmpresaController::class, 'listar_empresa_ajax'])->name('empresa.listar_empresa_ajax');
Route::get('empresa/modal_empresa/{id}', [EmpresaController::class, 'modal_empresa'])->name('empresa.modal_empresa');
Route::get('empresa/eliminar_empresa/{id}/{estado}', [EmpresaController::class, 'eliminar_empresa'])->name('empresa.eliminar_empresa');

// Route::get('vehiculos', [VehiculoController::class, 'index'])->name('vehiculos');
// Route::post('vehiculo/send', [VehiculoController::class, 'send'])->name('vehiculo.send');
// Route::get('vehiculo/consulta_vehiculo', [VehiculoController::class, 'consulta_vehiculo'])->name('vehiculo.consulta_vehiculo');
// Route::post('vehiculo/listar_vehiculo_ajax', [VehiculoController::class, 'listar_vehiculo_ajax'])->name('vehiculo.listar_vehiculo_ajax');
// Route::get('vehiculo/modal_vehiculo/{id}', [VehiculoController::class, 'modal_vehiculo'])->name('vehiculo.modal_vehiculo');
// Route::get('vehiculo/eliminar_vehiculo/{id}/{estado}', [VehiculoController::class, 'eliminar_vehiculo'])->name('vehiculo.eliminar_vehiculo');

Route::get('vehiculos', 'App\Http\Controllers\VehiculoController@index')->name('vehiculos.index');
Route::post('vehiculos', 'App\Http\Controllers\VehiculoController@store')->name('vehiculos.store');
Route::get('vehiculos/create', 'App\Http\Controllers\VehiculoController@create')->name('vehiculos.create');
Route::get('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@show')->name('vehiculos.show');
Route::put('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@update')->name('vehiculos.update');
Route::patch('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@update');
Route::delete('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@destroy')->name('vehiculos.destroy');
Route::get('vehiculos/{vehiculos}/edit', 'App\Http\Controllers\VehiculoController@edit')->name('vehiculos.edit');

Route::get('conductores', 'App\Http\Controllers\ConductoresController@index')->name('conductores.index');
Route::post('conductores', 'App\Http\Controllers\ConductoresController@store')->name('conductores.store');
Route::get('conductores/create', 'App\Http\Controllers\ConductoresController@create')->name('conductores.create');
Route::get('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@show')->name('conductores.show');
Route::put('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@update')->name('conductores.update');
Route::patch('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@update');
Route::delete('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@destroy')->name('conductores.destroy');
Route::get('conductores/{conductores}/edit', 'App\Http\Controllers\ConductoresController@edit')->name('conductores.edit');

// Route::resource('tablamaestras', 'App\Http\Controllers\TablaMaestraController');

Route::get('tablamaestras', 'App\Http\Controllers\TablaMaestraController@index')->name('tablamaestras.index');
Route::post('tablamaestras', 'App\Http\Controllers\TablaMaestraController@store')->name('tablamaestras.store');
Route::get('tablamaestras/create', 'App\Http\Controllers\TablaMaestraController@create')->name('tablamaestras.create');
Route::get('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@show')->name('tablamaestras.show');
Route::put('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@update')->name('tablamaestras.update');
Route::patch('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@update');
Route::delete('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@destroy')->name('tablamaestras.destroy');
Route::get('tablamaestras/{tablamaestras}/edit', 'App\Http\Controllers\TablaMaestraController@edit')->name('tablamaestras.edit');
