<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ViaturaController;

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
    Route::get('/viatura/history', [ViaturaController::class, 'history'])->name('viatura.history');
    Route::put('/viatura/activate/{viatura}', [ViaturaController::class, 'activate'])->name('viatura.activate');
    Route::put('/viatura/desactivate/{viatura}', [ViaturaController::class, 'desactivate'])->name('viatura.desactivate');
    Route::get('/viatura/solicitar', [ViaturaController::class, 'solicitarViatura'])->name('solicitar.viatura');
    Route::resource('viatura', 'ViaturaController');

    // Motoristas
    Route::get('/motorista/history', [MotoristaController::class, 'history'])->name('motorista.history');
    Route::put('/motorista/activate/{motorista}', [MotoristaController::class, 'activate'])->name('motorista.activate');
    Route::put('/motorista/desactivate/{motorista}', [MotoristaController::class, 'desactivate'])->name('motorista.desactivate');
    Route::resource('motorista', 'MotoristaController');

});

