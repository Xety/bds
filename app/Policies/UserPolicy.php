<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?User $model = null): bool
    {
        // First check if user can update any user and a user has been provided
        if($user->can('update user') && !is_null($model)) {
            // Check if the user level is superior or equal to the other user level he wants to edit.
            return $user->level() >= $model->level();
        }
        return $user->can('update user');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?User $model = null): bool
    {
        // First check if user can delete any user and a user has been provided
        if($user->can('delete user') && !is_null($model)) {
            // Check if the user level is superior or equal to the other user level he wants to edit.
            return $user->level() >= $model->level();
        }
        return $user->can('delete user');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->can('restore user');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search user');
    }

    /**
     * Determine whether the user can assign direct permission the model.
     */
    public function assignDirectPermission(User $user): bool
    {
        return $user->can('assign-direct-permission user');
    }
}
