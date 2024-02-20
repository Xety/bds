<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Maintenance;
use BDS\Models\User;

class MaintenancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny maintenance') && settings('maintenance_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Maintenance $maintenance): bool
    {
        if($user->can('view maintenance')) {
            return $maintenance->material->zone->site_id === getPermissionsTeamId();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create maintenance');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Maintenance $maintenance = null): bool
    {
        // First check if user can update any material and a $material has been provided
        if($user->can('update maintenance') && !is_null($maintenance)) {
            // Check that the user is not trying to update a material from another site where the material does not belong to.
            return $maintenance->material->site_id === getPermissionsTeamId();
        }
        return $user->can('update maintenance');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Maintenance $maintenance = null): bool
    {
        if($user->can('delete maintenance') && !is_null($maintenance)) {
            return $maintenance->material->site_id === getPermissionsTeamId();
        }
        return $user->can('delete maintenance');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export maintenance');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search maintenance');
    }
}
