<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Role;
use BDS\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Role $role = null): bool
    {
        // First check if user can update any role and a role has been provided
        if($user->can('update role') && !is_null($role)) {
            // Check if the user level is superior or equal to the role level he wants to edit.
            if ($user->level >= $role->level) {
                // Check that the user is not trying to update a role from another site where he does not have access
                return $role->site_id === null || $role->site_id === getPermissionsTeamId();
            }
            return false;
        }
        return $user->can('update role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Role $role = null): bool
    {
        if($user->can('delete role') && !is_null($role)) {
            return $user->level >= $role->level;
        }
        return $user->can('delete role');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search role');
    }
}
