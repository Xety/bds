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
        return $user->can('viewAny zone') && settings('zone_manage_enabled', true);
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
    public function update(User $user, ?Zone $zone = null): bool
    {
        // First check if user can update any zone and a $zone has been provided
        if($user->can('update zone') && !is_null($zone)) {
            // Check that the user is not trying to update a zone from another site where he does not have access
            return $zone->site_id === getPermissionsTeamId();
        }
        return $user->can('update zone');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Zone $zone = null): bool
    {
        if($user->can('delete zone') && !is_null($zone)) {
            return $zone->site_id === getPermissionsTeamId();
        }
        return $user->can('delete zone');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search zone');
    }
}
