<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\MotoristaController;
use App\Http\Controllers\ViaturaController;
use App\Http\Controllers\SolicitacaoController;

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
Route::post('auth/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt'
], function (){
    Route::get('viatura/list',[ViaturaController::class, 'viaturaList']);
    Route::get('motorista/list',[MotoristaController::class, 'motoristaList']);

    Route::get('solicitacao/list/{id}', [SolicitacaoController::class, 'apiIndex']);
    Route::get('solicitacao/download/{id}', [SolicitacaoController::class, 'print']);
    Route::post('solicitacao/store', [SolicitacaoController::class, 'apiStore']);
});
