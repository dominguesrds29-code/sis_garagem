<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ViaturaController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

    // Viaturas
    Route::post('/viatura/getdataActivelist/',[ViaturaController::class, 'getDatatableActiveList'])->name('viatura.activeList');
    Route::post('/viatura/getdataDesactivelist/',[ViaturaController::class, 'getDatatableDesactiveList'])->name('viatura.inactiveList');
    Route::get('/viatura/history', [ViaturaController::class, 'history'])->name('viatura.history');
    Route::put('/viatura/activate/{viatura}', [ViaturaController::class, 'activate'])->name('viatura.activate');
    Route::put('/viatura/desactivate/{viatura}', [ViaturaController::class, 'desactivate'])->name('viatura.desactivate');
    Route::resource('viatura', 'ViaturaController');

    // Motoristas
    Route::post('/motorista/getdataActivelist/',[MotoristaController::class, 'getDatatableActiveList'])->name('motorista.activeList');
    Route::post('/motorista/getdataDesactivelist/',[MotoristaController::class, 'getDatatableDesactiveList'])->name('motorista.inactiveList');
    Route::get('/motorista/history', [MotoristaController::class, 'history'])->name('motorista.history');
    Route::get('/motorista/imprimir/{motorista}', [MotoristaController::class, 'print'])->name('motorista.print');
    Route::put('/motorista/activate/{motorista}', [MotoristaController::class, 'activate'])->name('motorista.activate');
    Route::put('/motorista/desactivate/{motorista}', [MotoristaController::class, 'desactivate'])->name('motorista.desactivate');
    Route::resource('motorista', 'MotoristaController');

    // Solicitações
    Route::post('/solicitacao/getdataActivelist/',[SolicitacaoController::class, 'getDatatablePendingList'])->name('solicitacao.pendingList');
    Route::post('/solicitacao/getdataAuthlist/',[SolicitacaoController::class, 'getDatatableAuthList'])->name('solicitacao.authList');
    Route::post('/solicitacao/getdataAuthChlist/',[SolicitacaoController::class, 'getDatatableAuthChList'])->name('solicitacao.authChList');
    Route::post('/solicitacao/getdataAuthRplist/',[SolicitacaoController::class, 'getDatatableAuthRpList'])->name('solicitacao.authRpList');
    Route::post('/solicitacao/getdataHistorylist/',[SolicitacaoController::class, 'getDatatableHistoryList'])->name('solicitacao.historyList');
    Route::put('/solicitacao/approve/{solicitacao}', [SolicitacaoController::class, 'approve'])->name('solicitacao.approve');
    Route::put('/solicitacao/desapprove/{solicitacao}', [SolicitacaoController::class, 'desapprove'])->name('solicitacao.desapprove');
    Route::put('/solicitacao/archive/{solicitacao}', [SolicitacaoController::class, 'archive'])->name('solicitacao.archive');
    Route::get('/solicitacao/preauthorized', [SolicitacaoController::class, 'preauthorized'])->name('solicitacao.preauthorized');
    Route::get('/solicitacao/authorized', [SolicitacaoController::class, 'authorized'])->name('solicitacao.authorized');
    Route::get('/solicitacao/reproved', [SolicitacaoController::class, 'reproved'])->name('solicitacao.reproved');
    Route::get('/solicitacao/history', [SolicitacaoController::class, 'history'])->name('solicitacao.history');
    Route::get('/solicitacao/print/{solicitacao}', [SolicitacaoController::class, 'print'])->name('solicitacao.print');
    Route::resource('solicitacao', 'SolicitacaoController');

    //Permissões
    Route::post('/permission/getDatalist/',[PermissionController::class, 'getDataList'])->name('permission.datatable_list');
    Route::resource('permission', 'PermissionController');

    //Papéis
    Route::post('/role/getDatalist/',[RoleController::class, 'getDataList'])->name('roles.datatable_list');
    Route::resource('role', 'RoleController');

    //Usuários
    Route::get('user/profile/{user}',[UserController::class, 'profile'])->name('user.profile');
    Route::put('user/profile/{user}',[UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('/user/getdataActivelist/',[UserController::class, 'getDatatableActiveList'])->name('user.activeList');
    Route::post('/user/getdataDeletedlist/',[UserController::class, 'getDatatableDeletedList'])->name('user.deletedList');
    Route::put('/user/restore/{user}', [UserController::class, 'restore'])->name('user.activate');
    Route::get('/user/history', [UserController::class, 'history'])->name('user.history');
    Route::resource('user', 'UserController');
});

