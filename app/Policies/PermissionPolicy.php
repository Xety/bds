<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;
use BDS\Models\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny permission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->can('view permission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create permission');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        // Give update access to all permissions, remove to only allow created permission,
        // false to not allow any update.
        return $user->can('update permission');

        //return $user->id === $permission->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete permission');
    }
}
