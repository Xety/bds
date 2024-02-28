<?php

namespace BDS\Observers;

use BDS\Models\Calendar;
use Illuminate\Support\Facades\Auth;

class CalendarObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Calendar $calendar): void
    {
        $calendar->user_id = Auth::id();
        $calendar->site_id = getPermissionsTeamId();
    }
}
