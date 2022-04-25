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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('routes', function() {

    return App\Models\Route::all();
});

Route::get('routes/{id}/get', function($id) {

    return App\Models\Route::find($id);

});

Route::get('themes', function() {
    
    return App\Models\Theme::all();
});

Route::get('themes/{id}/get', function($id) {

    return App\Models\Theme::find($id);

});

