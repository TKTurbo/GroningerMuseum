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

Route::group([ 'middleware' => 'auth'], function()
{
    /*
    |--------------------------------------------------------------------------
    | Theme Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/themes', ['as' => 'themes.main', 'uses' => 'App\Http\Controllers\ThemeController@show_main']);

    /*
    |--------------------------------------------------------------------------
    | Route Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix'=>'routes','as'=>'routes.'], function(){

        Route::get('/', ['as' => 'main', 'uses' => 'App\Http\Controllers\RouteController@show_main']);
        Route::get('/create', ['as' => 'create', 'uses' => 'App\Http\Controllers\RouteController@showCreate']);
        Route::get('{route_id}/details', ['as' => 'details', 'uses' => 'App\Http\Controllers\RouteController@showDetails']);
        Route::post('/create', ['as' => 'store', 'uses' => 'App\Http\Controllers\RouteController@store']);
        Route::get('{route_id}/update', ['as' => 'show.update', 'uses' => 'App\Http\Controllers\RouteController@showUpdateForm']);
        Route::post('{route_id}/update', ['as' => 'update', 'uses' => 'App\Http\Controllers\RouteController@update']);
        Route::delete('{route_id}/delete', ['as' => 'delete', 'uses' => 'App\Http\Controllers\RouteController@delete']);

        /*
        |--------------------------------------------------------------------------
        | Route.subroutes Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'{route_id}/subroutes','as'=>'subroutes.'], function(){
           Route::get('/create', ['as' => 'create', 'uses' => 'App\Http\Controllers\SubRouteController@create']);
           Route::post('/create', ['as' => 'store', 'uses' => 'App\Http\Controllers\SubRouteController@store']);
           Route::delete('/delete/{subroute_id}', ['as' => 'delete', 'uses' => 'App\Http\Controllers\SubRouteController@delete']);
           Route::get('/order', ['as' => 'order', 'uses' => 'App\Http\Controllers\SubRouteController@showOrdering']);
           Route::post('/order', ['as' => 'order.store', 'uses' => 'App\Http\Controllers\SubRouteController@updateOrdering']);

           Route::post('/upload-image/{subroute_id}', ['as' => 'upload-image', 'uses' => 'App\Http\Controllers\SubRouteController@uploadImage']);

           Route::get('/subroute/{subroute_id}', ['as' => 'subroute.details', 'uses' => 'App\Http\Controllers\SubRouteController@showSubroute']);
        });

    });

});
require __DIR__.'/auth.php';
