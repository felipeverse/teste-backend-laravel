<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Rota da API para registrar novo usuário
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);

// Rota da API para login de usuário
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

// Rotas protegidas
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    // Retorna dados do usuário logado
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    // Rota da API para logout do usuário
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);

    // Lista todos os munícipios url/api/municipios
    Route::get('municipios', 'App\Http\Controllers\MunicipioController@index');

});