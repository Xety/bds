<?php

namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\PartExit;
use BDS\Models\User;

class PartExitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny partExit') && settings('part_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PartExit $partExit): bool
    {
        return $user->can('view partExit');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create partExit');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?PartExit $partExit = null): bool
    {
        // First check if user can update any partExit and a $partExit has been provided
        if($user->can('update partExit') && !is_null($partExit)) {
            // Check that the user is not trying to update a partExit from another site where the partExit does not belong to.
            return $partExit->part->site_id === getPermissionsTeamId();
        }
        return $user->can('update partExit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?PartExit $partExit = null): bool
    {
        if($user->can('delete partExit') && !is_null($partExit)) {
            return $partExit->part->site_id === getPermissionsTeamId();
        }
        return $user->can('delete partExit');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export partExit');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search partExit');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOtherSite(User $user): bool
    {
        return $user->can('view-other-site partExit');
    }
}
