<?php

namespace BDS\Observers;

use BDS\Models\Calendar;
use BDS\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class CalendarEventObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(CalendarEvent $calendarEvent): void
    {
        $calendarEvent->user_id = Auth::id();
        $calendarEvent->site_id = getPermissionsTeamId();
    }
}
