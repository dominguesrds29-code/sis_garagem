<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\MotoristaController;
use App\Http\Controllers\SaidaViaturaController;
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
    Route::group(['prefix' => 'viatura', 'as' => 'viatura.'], function () {
        Route::get('list',[ViaturaController::class, 'viaturaList']);
        Route::get('getKilometragem/{id}',[ViaturaController::class, 'getKilometragem'])->name('getKilometragem');
    });

    Route::get('motorista/list',[MotoristaController::class, 'motoristaList']);

    Route::group(['prefix' => 'saidaviatura', 'as' => 'saidaviatura.'], function () {
        Route::get('list', [SaidaViaturaController::class, 'apiIndex'])->name('index');
        Route::post('store', [SaidaViaturaController::class, 'apiStore'])->name('store');
        Route::put('storeReturn', [SaidaViaturaController::class, 'apiStoreReturn'])->name('storeReturn');
    });

    Route::group(['prefix' => 'solicitacao', 'as' => 'solicitacao.'], function () {
        Route::get('list/{id}', [SolicitacaoController::class, 'apiIndex'])->name('index');
        Route::get('download/{id}', [SolicitacaoController::class, 'print'])->name('print');
        Route::post('store', [SolicitacaoController::class, 'apiStore'])->name('store');
    });
});
