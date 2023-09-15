<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Conductore;
use App\Http\Controllers\ConductoreController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

//Route::post('persona/send_personad', [PersonaDetalleController::class, 'send_personad'])->name('store');

// Route::post('conductores', 'App\Http\Controllers\ConductoreController@store');

Route::resource('conductores', 'App\Http\Controllers\ConductoreController', ['except' => ['store']]);
// Route::resource('conductores', 'App\Http\Controllers\ConductoreController');

Route::post('conductores/store', [ConductoreController::class, 'store'])->name('conductores.store');

// Route::post('conductores/store', function(){
//     dd('ruta OK');
// })->name('conductores.store');
