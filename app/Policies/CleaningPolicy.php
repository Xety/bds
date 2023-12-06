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
        return $user->can('viewAny cleaning') && settings('cleaning_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cleaning $cleaning): bool
    {
        return $user->can('view cleaning');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create cleaning') && settings('cleaning_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Cleaning $cleaning = null): bool
    {
        // First check if user can update any cleaning and a $cleaning has been provided
        if($user->can('update cleaning') && !is_null($cleaning)) {
            // Check that the user is not trying to update a cleaning from another site where the cleaning does not belong to.
            return $cleaning->material->zone->site_id === getPermissionsTeamId();
        }
        return $user->can('update cleaning');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?Cleaning $cleaning = null): bool
    {
        if($user->can('delete cleaning') && !is_null($cleaning)) {
            return $cleaning->material->zone->site_id === getPermissionsTeamId();
        }
        return $user->can('delete cleaning');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export cleaning');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search cleaning');
    }

    /**
     * Determine whether the user can generate the cleaning plan.
     */
    public function generatePlan(User $user): bool
    {
        return $user->can('generatePlan cleaning');
    }
}
