<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubRoute;
use App\Models\Route;
use App\Processors\SubRouteProcessor;

class SubRouteController extends Controller
{
    public function create($route_id)
    {
        $attr = [
            'header' => 'Nieuwe subroute(s) aanmaken',
            'button' => 'Subroute(s) opslaan...'
        ];

        $min_order = SubRoute::max('order_number');

        return view('routes.subroutes.form', compact('attr','min_order', 'route_id'));
    }

    public function store($route_id, Request $request)
    {
        $subroute = New SubRoute;
        $processor = new SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->store();

        return redirect(route('routes.details', [$route_id = $route_id]));
    }

    public function showOrdering($route_id)
    {

        $subroutes = SubRoute::where('route_id', $route_id)->orderBy('order_number')->get();

        $attr = [
            'header' => 'Het orderen van de subroutes',
            'button' => 'Sla nieuwe ordering op'
        ];

        return view('routes.subroutes.ordering', compact('attr', 'subroutes'));
    }

    public function updateOrdering($route_id, Request $request)
    {
        $subroute = new SubRoute;
        $processor = new SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->updateOrdering();

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