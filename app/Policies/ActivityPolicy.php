<?php
namespace BDS\Policies;

use BDS\Models\Activity;
use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\User;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny activity');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activity $activity): bool
    {
        return $user->can('view activity');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?Activity $activity = null): bool
    {
        return $user->can('delete activity');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search activity');
    }
}
