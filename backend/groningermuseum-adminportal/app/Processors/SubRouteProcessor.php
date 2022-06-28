<?php

namespace App\Processors;

use App\Models\Route;
use App\Models\SubRoute;
use Cion\TextToSpeech\Facades\TextToSpeech;
use Illuminate\Http\Request;
use File;

class SubRouteProcessor
{
	protected $request;
	protected $route;
	protected $route_id;

	public function __construct($request, $route_id, SubRoute $subroute)
	{
		$this->request = $request;
		$this->subroute = $subroute;
		$this->route_id = (int)$route_id;
	}

	public function store()
	{
		// Get the values from the request, insert it into the route and save it
		$this->subroute->route_id = $this->route_id;
		$this->subroute->name = $this->request['name'];
		$this->subroute->description = $this->request['description'];
		$this->subroute->order_number = $this->request['quantity'];
		$this->subroute->save();

	}

	public function updateOrdering()
	{
        // Update the ordering
		$new_order = [];

		foreach(explode(',',$this->request['new_order']) as $row)
		{
			array_push($new_order,(int)$row);
		}

		for ($i=0; $i < count($new_order); $i++)
		{
			$subroutes[$i] = SubRoute::where('order_number', $new_order[$i])->first();
			$subroutes[$i]->order_number = $i + 1;
		}

		foreach($subroutes as $subroute) $subroute->update();

	}

	public function update()
	{
		// update the values from the route
		$this->subroute->name = $this->request['name'];
		$this->subroute->update();
	}

	public function delete()
	{

        // delete the TTS message from the public storage.
        $location = 'media/TTS/output'.$this->subroute->id.'.mp3';
        if(File::exists(public_path($location))) {
            File::delete(public_path($location));
        }

        // Delete the entire subroute.
		$this->subroute->delete();
	}

}
