<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Processors\RouteProcessor;
use App\Models\Route;
use App\Models\Theme;
use App\Models\SubRoute;

class RouteController extends Controller
{
    public function show_main()
    {
        // Get all the routes.
        $routes = Route::all();

        // Attributes for the view
        $attr = [
            'header' => "Alle routes",
            'button' => "Nieuwe route aanmaken"
        ];

        return view('routes.main', compact('routes', 'attr'));
    }

    public function showCreate()
    {
        // Attributes for the view
        $attr = [
            'header' => "Nieuwe route aanmaken",
            'button' => "Nieuwe route opslaan",
            'themes' => Theme::all(),
            'method' => 'POST',
            'form-route' => 'routes.store'
        ];

        return view('routes.form', compact('attr'));
    }

    public function showUpdateForm($route_id)
    {
        $route = Route::find($route_id);

        $attr = [
            'header' => $route->name,
            'button' => 'Route updaten en opslaan',
            'themes' => Theme::all(),
            'method' => 'PUT',
            'form-route' => 'routes.update'
        ];

        return view ('routes.form', compact('route', 'attr'));
    }


    public function showDetails($route_id)
    {
        // detail view
        $selected_route = Route::find($route_id);
        $subroutes = SubRoute::where('route_id', $route_id)->orderBy('order_number')->get();

        $attr = [
            'header' => $selected_route->name,
        ];

        return view('routes.details', compact('selected_route','subroutes', 'attr'));
    }

    public function store(Request $request)
    {
        // Iniatalize a new route and processor. Handle the request and store it
        $route = New Route;
        $processor = New RouteProcessor($request->all(), $route);
        $processor->store();

        return redirect(route('routes.main'));
    }

    public function update(Request $request, $route_id)
    {
        // update...
        $route = Route::find($route_id);
        $processor = New RouteProcessor($request->all(), $route);
        $processor->update();

        $attr = [
            'header' => $route->name,
        ];

        return redirect(route('routes.details', [$route_id = $route->id]));


    }

    public function delete(Request $request, $route_id)
    {
        // Get the selected route, iniatalize a new processor and delete the selected route.
        $route = Route::find($route_id);
        $processor = New RouteProcessor($request->all(), $route);
        $processor->delete();

        return redirect(route('routes.main'));
    }
}
