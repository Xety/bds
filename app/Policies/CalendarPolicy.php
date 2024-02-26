<?php
namespace BDS\Policies;

use BDS\Models\Calendar;
use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\User;

class CalendarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny calendar') && settings('calendar_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Calendar $calendar): bool
    {
        return $user->can('view calendar');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create calendar') && settings('calendar_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Calendar $calendar = null): bool
    {
        if($user->can('update calendar') && !is_null($calendar)) {
            return $calendar->site_id === getPermissionsTeamId();
        }
        return $user->can('update calendar');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?Calendar $calendar = null): bool
    {
        if($user->can('delete calendar') && !is_null($calendar)) {
            return $calendar->site_id === getPermissionsTeamId();
        }
        return $user->can('delete calendar');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export calendar');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search calendar');
    }
}
