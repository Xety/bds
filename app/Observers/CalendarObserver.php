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

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Calendar $calendar): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($calendar)
                ->event('deleted')
                ->withProperties(['attributes' => $calendar->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'évènement :subject.title du calendrier.');
        }
    }
}
