<?php

namespace BDS\Observers;

use BDS\Events\Site\CreatedEvent;
use BDS\Models\Site;

class SiteObserver
{
    /**
     * Handle the "created" event.
     */
    public function created(Site $site): void
    {
        event(new CreatedEvent($site));
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Site $site): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($site)
                ->event('deleted')
                ->withProperties(['attributes' => $site->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé le site :subject.name.');
        }
    }
}
