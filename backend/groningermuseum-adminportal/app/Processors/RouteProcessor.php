<?php

namespace App\Processors;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteProcessor 
{
	protected $request;
	protected $route;

	public function __construct($request, Route $route)
	{
		$this->request = $request;
		$this->route = $route;
	}

	public function store()
	{
		// Get the values from the request, insert it into the route and save it
		$this->route->theme_id = $this->request['theme'];
		$this->route->user_id = Auth()->user()->id;
		$this->route->name = $this->request['name'];
		$this->route->save();
	}

	public function update()
	{
		// update the values from the route
		$this->route->theme_id = $this->request['theme'];
		$this->route->user_id = Auth()->user()->id;
		$this->route->name = $this->request['name'];
		$this->route->update();
	}

	public function delete()
	{
		// delete route...
		$this->route->delete();
	}

}