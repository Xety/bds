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

    /**
     * Handle the "deleting" event.
     */
    public function deleting(CalendarEvent $calendarEvent): void
    {
        $calendars = $calendarEvent->calendars()->pluck('id')->toArray();
        Calendar::destroy($calendars);
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
                ->log('L\'utilisateur :causer.full_name à supprimé le type d\'évènement :subject.name.');
        }
    }
}
