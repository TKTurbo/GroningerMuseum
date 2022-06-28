<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubRoute;
use App\Models\Route;
use App\Processors\SubRouteProcessor;
use Cion\TextToSpeech\Facades\TextToSpeech;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubRouteController extends Controller
{
    /**
     * Create a new subroute
     *
     * @return view
     */
    public function create($route_id)
    {
        // Attributes
        $attr = [
            'header' => 'Nieuwe subroute(s) aanmaken',
            'button' => 'Subroute(s) opslaan...'
        ];

        // Get the minimal order number from this current selected subroute
        $min_order = SubRoute::where('route_id', $route_id)->max('order_number');

        return view('routes.subroutes.form', compact('attr','min_order', 'route_id'));
    }

    /**
     * Store a new subroute
     *
     * @return subroute
     */
    public function store($route_id, Request $request)
    {

        // Iniatialize a new subroute processor and store the newest subroute
        $subroute = New SubRoute;
        $processor = new SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->store();

        // If the image checkbox has been checked, set the different attributes and return a different view
        if (isset($request->all()['image_check']))
        {
            $attr = [
                'header' => 'Afbeelding uploaden voor ' . $processor->subroute->name,
                'button' => 'Afbeelding opslaan...',
                'upload' => True
        ];
        // Get the made subroute from the processor.
        $subroute = $processor->subroute;

            // Return the form for the image.
            return view('routes.subroutes.form', compact('attr', 'route_id', 'subroute'));
        }
        // Redirect the user to the details view
        return redirect(route('routes.details', [$route_id = $route_id]));
    }

    /**
     * Upload an image
     *
     * @return image
     */
    public function uploadImage($route_id, $subroute_id, Request $request)
    {
        // Upload the image..
        $subroute = SubRoute::find($subroute_id);
        $subroute->addMedia($request->all()['files'][0])->toMediaCollection();
    }

    /**
     * Show the current order
     *
     * @return view
     */
    public function showOrdering($route_id)
    {
        // Get the subroutes and sort them based on their order.
        $subroutes = SubRoute::where('route_id', $route_id)->orderBy('order_number')->get();

        // Set the attributes.
        $attr = [
            'header' => 'Het orderen van de subroutes',
            'button' => 'Sla nieuwe ordering op'
        ];

        return view('routes.subroutes.ordering', compact('attr', 'subroutes'));
    }

    /**
     * Update the existing order
     *
     * @return void
     */
    public function updateOrdering($route_id, Request $request)
    {
        // Update the order, let the processor handle it.
        $subroute = new SubRoute;
        $processor = new SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->updateOrdering();

        return redirect(route('routes.details', [$route_id = $route_id]));
    }

    /**
     * Delete a subroute
     *
     * @return void
     */
    public function delete(Request $request, $route_id, $subroute_id)
    {
        // Get the selected route, iniatalize a new processor and delete the selected route.
        $subroute = Subroute::find($subroute_id);
        $processor = New SubRouteProcessor($request->all(), $route_id, $subroute);
        $processor->delete();

        return redirect(route('routes.details', [$route_id = $route_id]));
    }

    /**
     * Show the detail view of a subroute
     *
     * @return view
     */
    public function showSubroute($route_id, $subroute_id)
    {
        // Set the attributes.
        $attr = [
            'header' => 'subroute', ];

        // Find the subroute
        $subroute = SubRoute::find($subroute_id);

        // Get the Text-To-Speech location.
        $location = 'TTS/output'.$subroute->id.'.mp3';

        // Return the view.
        return view('routes.subroutes.details', compact('subroute', 'location', 'attr'));
    }
}
