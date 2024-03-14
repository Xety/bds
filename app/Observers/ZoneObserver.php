<?php

namespace BDS\Observers;

use BDS\Events\Site\CreatedEvent;
use BDS\Models\Site;

class ZoneObserver
{
    /**
     * Handle the "created" event.
     */
    public function created(Site $site): void
    {
        //
    }
}
