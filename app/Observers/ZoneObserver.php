<?php

namespace BDS\Observers;

use BDS\Models\Zone;

class ZoneObserver
{
    /**
     * Handle the "deleted" event.
     */
    public function deleted(Zone $zone): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($zone)
                ->event('deleted')
                ->withProperties(['attributes' => $zone->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé la zone :subject.name.');
        }
    }
}
