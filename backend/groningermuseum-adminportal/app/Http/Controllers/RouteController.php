<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Processors\RouteProcessor;
use App\Models\Route;
use App\Models\Theme;
use App\Models\SubRoute;

class RouteController extends Controller
{

    /**
     * Show the main page for the routes
     *
     * @return view
     */
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

    /**
     * Show the create route form
     *
     * @return view
     */
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

    /**
     * Show the update form
     *
     * @param route_id: The identifier of the route.
     * @return view
     */
    public function showUpdateForm($route_id)
    {
        // Find the route and sees if it exists.
        $route = Route::find($route_id);

        // Set the attributes.
        $attr = [
            'header' => $route->name,
            'button' => 'Route updaten en opslaan',
            'themes' => Theme::all(),
            'method' => 'PUT',
            'form-route' => 'routes.update'
        ];

        return view ('routes.form', compact('route', 'attr'));
    }

    /**
     * Show the details page of a route
     *
     * @param $route_id = The identifier of the route.
     * @return 'routes.details'
     */
    public function showDetails($route_id)
    {
        // Find the selected route and find the subroutes of that route.
        $selected_route = Route::find($route_id);
        $subroutes = SubRoute::where('route_id', $route_id)->orderBy('order_number')->get();
        $all_subroutes = Subroute::all();

        $attr = [
            'header' => $selected_route->name,
        ];

        return view('routes.details', compact('selected_route','subroutes', 'all_subroutes', 'attr'));
    }

    /**
     * Store a route
     * @param Request $request
     * @return Route $route
     */
    public function store(Request $request)
    {
        // Iniatalize a new route and processor. Handle the request and store it
        $route = New Route;
        $processor = New RouteProcessor($request->all(), $route);
        $processor->store();

        return redirect(route('routes.main'));
    }

    /**
     * Update a new route
     *
     * @param Request $request
     * @param $route_id: The identifier of the given route
     * @return view
     */
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

    /**
     * Delete a route
     * @param Request $request
     * @param $route_id: The identifier of the given route
     * @return view/subroute/form
     */
    public function delete(Request $request, $route_id)
    {
        // Get the selected route, iniatalize a new processor and delete the selected route.
        $route = Route::find($route_id);
        $processor = New RouteProcessor($request->all(), $route);
        $processor->delete();

        return redirect(route('routes.main'));
    }
}
