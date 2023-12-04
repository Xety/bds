<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Cleaning;
use BDS\Models\User;

class CleaningPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny cleaning');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cleaning $cleaning): bool
    {
        return $user->can('view cleaning');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export cleaning');
    }

    /**
     * Determine whether the user can generate the cleaning plan.
     */
    public function generatePlan(User $user): bool
    {
        return $user->can('generatePlan cleaning');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create cleaning');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        // Give update access to all cleanings, remove to only allow created cleaning,
        // false to not allow any update.
        return $user->can('update cleaning');

        //return $user->id === $cleaning->user_id;
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user): bool
    {
        return $user->can('delete cleaning');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search zone');
    }
}
