<?php

namespace App\Listeners;

use App\Events\payRequestSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class storeData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  payRequestSent  $event
     * @return void
     */
    public function handle(payRequestSent $event)
    {
        //
    }
}
