<?php

namespace App\Processors;

use App\Models\SubRoute;
use Illuminate\Http\Request;

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

	public function update()
	{
		// update the values from the route
		$this->subroute->name = $this->request['name'];
		$this->subroute->update();
	}

	public function delete()
	{
		$this->subroute->delete();
	}

}