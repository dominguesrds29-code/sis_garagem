<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ViaturaController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaidaViaturaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnalyticsController;

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'] , function() {

    // Analytics / Estatísticas
    Route::get('estatisticas', [AnalyticsController::class, 'index'])->name('estatisticas.index');

    // Viaturas
    Route::group(['as' => 'viatura.', 'prefix' => 'viatura'], function () {
        Route::post('getdataActivelist/',[ViaturaController::class, 'getDatatableActiveList'])->name('activeList');
        Route::post('getdataDesactivelist/',[ViaturaController::class, 'getDatatableDesactiveList'])->name('inactiveList');
        Route::get('history', [ViaturaController::class, 'history'])->name('history');
        Route::get('grafico', [ViaturaController::class, 'grafico'])->name('grafico');
        Route::put('activate/{viatura}', [ViaturaController::class, 'activate'])->name('activate');
        Route::put('desactivate/{viatura}', [ViaturaController::class, 'desactivate'])->name('desactivate');
        Route::get('kilometragem/{id}', [ViaturaController::class, 'getKilometragem'])->name('getKilometragem');
    });
    Route::resource('viatura', 'ViaturaController');

    // Saída de Viaturas
    Route::group(['as' => 'saidaviatura.', 'prefix' => 'saidaviatura'], function () {
        Route::post('getdataActivelist/',[SaidaViaturaController::class, 'getDatatableActiveList'])->name('activeList');
        Route::post('getdataCompletelist/',[SaidaViaturaController::class, 'getDatatableCompleteList'])->name('completeList');
        Route::get('return/{id}',[SaidaViaturaController::class, 'return'])->name('return');
        Route::put('return/{id}',[SaidaViaturaController::class, 'storeReturn'])->name('storeReturn');
        Route::get('history', [SaidaViaturaController::class, 'history'])->name('history');
        Route::get('grafico', [SaidaViaturaController::class, 'grafico'])->name('grafico');
        Route::get('create/{id?}/', [SaidaViaturaController::class, 'create'])->name('utilizar');
    });
    Route::resource('saidaviatura', 'SaidaViaturaController');

    // Motoristas
    Route::group(['as' => 'motorista.', 'prefix' => 'motorista'], function () {
        Route::post('getdataActivelist/',[MotoristaController::class, 'getDatatableActiveList'])->name('activeList');
        Route::post('getdataDesactivelist/',[MotoristaController::class, 'getDatatableDesactiveList'])->name('inactiveList');
        Route::get('history', [MotoristaController::class, 'history'])->name('history');
        Route::get('imprimir/{motorista}', [MotoristaController::class, 'print'])->name('print');
        Route::put('activate/{motorista}', [MotoristaController::class, 'activate'])->name('activate');
        Route::put('desactivate/{motorista}', [MotoristaController::class, 'desactivate'])->name('desactivate');
    });
    Route::resource('motorista', 'MotoristaController');

    // Solicitações
    Route::group(['as' => 'solicitacao.', 'prefix' => 'solicitacao'], function () {
        Route::post('getdataActivelist/',[SolicitacaoController::class, 'getDatatablePendingList'])->name('pendingList');
        Route::post('getdataAuthlist/',[SolicitacaoController::class, 'getDatatableAuthList'])->name('authList');
        Route::post('getdataAuthChlist/',[SolicitacaoController::class, 'getDatatableAuthChList'])->name('authChList');
        Route::post('getdataAuthRplist/',[SolicitacaoController::class, 'getDatatableAuthRpList'])->name('authRpList');
        Route::post('getdataHistorylist/',[SolicitacaoController::class, 'getDatatableHistoryList'])->name('historyList');
        Route::put('approve/{solicitacao}', [SolicitacaoController::class, 'approve'])->name('approve');
        Route::put('desapprove/{solicitacao}', [SolicitacaoController::class, 'desapprove'])->name('desapprove');
        Route::put('archive/{solicitacao}', [SolicitacaoController::class, 'archive'])->name('archive');
        Route::get('preauthorized', [SolicitacaoController::class, 'preauthorized'])->name('preauthorized');
        Route::get('authorized', [SolicitacaoController::class, 'authorized'])->name('authorized');
        Route::get('reproved', [SolicitacaoController::class, 'reproved'])->name('reproved');
        Route::get('history', [SolicitacaoController::class, 'history'])->name('history');
        Route::get('print/{solicitacao}', [SolicitacaoController::class, 'print'])->name('print');
    });
    Route::resource('solicitacao', 'SolicitacaoController');

    //Permissões
    Route::post('/permission/getDatalist/',[PermissionController::class, 'getDataList'])->name('permission.datatable_list');
    Route::resource('permission', 'PermissionController');

    //Papéis
    Route::post('/role/getDatalist/',[RoleController::class, 'getDataList'])->name('roles.datatable_list');
    Route::resource('role', 'RoleController');

    //Usuários
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('profile/{user}',[UserController::class, 'profile'])->name('profile');
        Route::put('profile/{user}',[UserController::class, 'updateProfile'])->name('updateProfile');
        Route::post('getdataActivelist/',[UserController::class, 'getDatatableActiveList'])->name('activeList');
        Route::post('getdataDeletedlist/',[UserController::class, 'getDatatableDeletedList'])->name('deletedList');
        Route::put('restore/{user}', [UserController::class, 'restore'])->name('activate');
        Route::get('history', [UserController::class, 'history'])->name('history');
    });
    Route::resource('user', 'UserController');
});

