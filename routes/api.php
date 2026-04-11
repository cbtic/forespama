<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\AsistenciaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

    });

Route::post('/api-login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/asistencias', [AsistenciaController::class, 'index']);
Route::middleware('auth:sanctum')->post('/asistencias/confirmar', [AsistenciaController::class, 'confirmar']);

JsonApiRoute::server('v1')
->prefix('v1')
->namespace('App\Http\Controllers\Api\V1')
->resources(function ($server) {

    $server->resource('ubigeos')
        ->parameter('id');

});
