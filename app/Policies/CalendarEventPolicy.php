<?php
namespace BDS\Policies;

use BDS\Models\CalendarEvent;
use BDS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny calendar event') && settings('calendar_event_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CalendarEvent $calendarEvent): bool
    {
        return $user->can('view calendar event');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create calendar event') && settings('calendar_event_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?CalendarEvent $calendarEvent = null): bool
    {
        if($user->can('update calendar event') && !is_null($calendarEvent)) {
            return $calendarEvent->site_id === getPermissionsTeamId();
        }
        return $user->can('update calendar event');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?CalendarEvent $calendarEvent = null): bool
    {
        if($user->can('delete calendar event') && !is_null($calendarEvent)) {
            return $calendarEvent->site_id === getPermissionsTeamId();
        }
        return $user->can('delete calendar event');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search calendar event');
    }
}
