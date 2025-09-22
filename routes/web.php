<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PostController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});

// Rutas para Area
Route::get('/area', [\App\Http\Controllers\AreaController::class, 'index'])->name('area.index');
Route::get('/area/all', [\App\Http\Controllers\AreaController::class, 'all'])->name('area.all');
Route::post('/area/all_ajax', [\App\Http\Controllers\AreaController::class, 'all_ajax'])->name('area.all_ajax');
Route::get('/area/modal/{id}', [\App\Http\Controllers\AreaController::class, 'modal'])->name('area.modal');
Route::post('/area/send', [\App\Http\Controllers\AreaController::class, 'send'])->name('area.send');
Route::get('/area/eliminar/{id}/{estado}', [\App\Http\Controllers\AreaController::class, 'eliminar'])->name('area.eliminar');

// Rutas para Tienda
Route::get('/tienda', [\App\Http\Controllers\TiendaController::class, 'index'])->name('tienda.index');
Route::get('/tienda/all', [\App\Http\Controllers\TiendaController::class, 'all'])->name('tienda.all');
Route::post('/tienda/all_ajax', [\App\Http\Controllers\TiendaController::class, 'all_ajax'])->name('tienda.all_ajax');
Route::get('/tienda/modal/{id}', [\App\Http\Controllers\TiendaController::class, 'modal'])->name('tienda.modal');
Route::post('/tienda/send', [\App\Http\Controllers\TiendaController::class, 'send'])->name('tienda.send');
Route::get('/tienda/eliminar/{id}/{estado}', [\App\Http\Controllers\TiendaController::class, 'eliminar'])->name('tienda.eliminar');

// Rutas para Moneda
Route::get('/moneda', [\App\Http\Controllers\MonedaController::class, 'index'])->name('moneda.index');
Route::get('/moneda/all', [\App\Http\Controllers\MonedaController::class, 'all'])->name('moneda.all');
Route::post('/moneda/all_ajax', [\App\Http\Controllers\MonedaController::class, 'all_ajax'])->name('moneda.all_ajax');
Route::get('/moneda/modal/{id}', [\App\Http\Controllers\MonedaController::class, 'modal'])->name('moneda.modal');
Route::post('/moneda/send', [\App\Http\Controllers\MonedaController::class, 'send'])->name('moneda.send');
Route::get('/moneda/eliminar/{id}/{estado}', [\App\Http\Controllers\MonedaController::class, 'eliminar'])->name('moneda.eliminar');
