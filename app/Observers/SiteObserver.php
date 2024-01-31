<?php

namespace BDS\Observers;

use BDS\Events\Site\CreatedEvent;
use BDS\Models\Site;

class SiteObserver
{
    /**
     * Handle the Site "created" event.
     */
    public function created(Site $site): void
    {
        event(new CreatedEvent($site));
    }
}