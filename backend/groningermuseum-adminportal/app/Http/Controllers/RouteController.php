<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function show_main()
    {

        $routes = Route::all();

        return view('routes.main', [
            'routes' => $routes
        ]);
    }
}
