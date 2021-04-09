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

    Route::get('/menuproyek','MenuProyekController@index');
    Route::resource('user','UserController');

    Route::get('/rencana/{id}','RencanaController@index');
    Route::get('/realisasi/{id}','RealisasiController@index');
    Route::post('/realisasi/store','RealisasiController@store');
    Route::put('/realisasi/update','RealisasiController@update');
    Route::delete('/realisasi/delete','RealisasiController@destroy');
});
