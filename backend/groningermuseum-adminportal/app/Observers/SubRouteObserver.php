<?php

namespace App\Observers;

use App\Jobs\handleTTSJob;
use App\Models\SubRoute;

class SubRouteObserver
{
    /**
     * Handle the SubRoute "created" event.
     *
     * @param  \App\Models\SubRoute  $subRoute
     * @return void
     */
    public function created(SubRoute $subRoute)
    {
        handleTTSJob::dispatch($subRoute);
    }

    /**
     * Handle the SubRoute "updated" event.
     *
     * @param  \App\Models\SubRoute  $subRoute
     * @return void
     */
    public function updated(SubRoute $subRoute)
    {
        //
    }

    /**
     * Handle the SubRoute "deleted" event.
     *
     * @param  \App\Models\SubRoute  $subRoute
     * @return void
     */
    public function deleted(SubRoute $subRoute)
    {

    }

    /**
     * Handle the SubRoute "restored" event.
     *
     * @param  \App\Models\SubRoute  $subRoute
     * @return void
     */
    public function restored(SubRoute $subRoute)
    {
        //
    }

    /**
     * Handle the SubRoute "force deleted" event.
     *
     * @param  \App\Models\SubRoute  $subRoute
     * @return void
     */
    public function forceDeleted(SubRoute $subRoute)
    {
        //
    }
}
