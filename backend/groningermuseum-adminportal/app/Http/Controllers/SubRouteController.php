<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubRoute;
use App\Processors\SubRouteProcessor;

class SubRouteController extends Controller
{
    public function create($route_id)
    {
        $attr = [
            'header' => 'Nieuwe subroute(s) aanmaken',
            'button' => 'Subroute(s) opslaan...'
        ];

        return view('routes.subroutes.form', compact('attr', 'route_id'));
    }

    public function store($route_id, Request $request)
    {
        $subroute = New SubRoute;
        $processor = new SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->store();

        return redirect(route('routes.details', [$route_id = $route_id]));
    }

    public function delete(Request $request, $route_id, $subroute_id)
    {
        // Get the selected route, iniatalize a new processor and delete the selected route.
        $subroute = Subroute::find($subroute_id);
        $processor = New SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->delete();

        return redirect(route('routes.details', [$route_id = $route_id]));
    }
}
