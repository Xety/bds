<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Incident;
use BDS\Models\User;

class IncidentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny incident');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Incident $incident): bool
    {
        if($user->can('view incident')) {
            return $incident->site_id === getPermissionsTeamId();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create incident');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Incident $incident = null): bool
    {
        // First check if user can update any material and a $material has been provided
        if($user->can('update incident') && !is_null($incident)) {
            // Check that the user is not trying to update a material from another site where the material does not belong to.
            return $incident->site_id === getPermissionsTeamId();
        }
        return $user->can('update incident');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Incident $incident = null): bool
    {
        if($user->can('delete incident') && !is_null($incident)) {
            return $incident->site_id === getPermissionsTeamId();
        }
        return $user->can('delete incident');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export incident');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search incident');
    }
}
