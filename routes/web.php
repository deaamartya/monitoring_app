<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::prefix('admin')->middleware(['auth'])->group(function(){
    Route::get('/','AdminController@index');

    Route::resource('menuproyek','MenuProyekController');
    Route::resource('user','UserController');
    Route::resource('rencana','RencanaController');
    Route::resource('realisasi','RealisasiController');

    Route::post('/realisasi/get-rencana','RealisasiController@getRencana');
    Route::get('/exportexcel','MenuProyekController@exportexcel');
});
