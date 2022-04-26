<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/themes', ['as' => 'themes.main', 'uses' => 'App\Http\Controllers\ThemeController@show_main']);

Route::group(['prefix'=>'routes','as'=>'routes.'], function(){

    Route::get('/', ['as' => 'main', 'uses' => 'App\Http\Controllers\RouteController@show_main']);
    Route::get('/create', ['as' => 'create', 'uses' => 'App\Http\Controllers\RouteController@showCreate']);
    Route::get('{route_id}/details', ['as' => 'details', 'uses' => 'App\Http\Controllers\RouteController@showDetails']);
    Route::post('/create', ['as' => 'store', 'uses' => 'App\Http\Controllers\RouteController@store']);
    Route::delete('{route_id}/delete', ['as' => 'delete', 'uses' => 'App\Http\Controllers\RouteController@delete']);

});

require __DIR__.'/auth.php';
