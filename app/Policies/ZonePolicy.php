<?php

namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\User;
use BDS\Models\Zone;

class ZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny zone');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Zone $zone): bool
    {
        return $user->can('view zone');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create zone');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        // Give update access to all zones, remove to only allow created zone,
        // false to not allow any update.
        return $user->can('update zone');

        //return $user->id === $zone->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete zone');
    }
}
