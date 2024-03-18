<?php

namespace BDS\Observers;

use BDS\Models\Activity;

class ActivityObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Activity $activity): void
    {
        $activity->site_id = getPermissionsTeamId();
    }
}
