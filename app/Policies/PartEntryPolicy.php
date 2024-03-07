<?php

namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\PartEntry;
use BDS\Models\User;

class PartEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny partEntry') && settings('part_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PartEntry $partEntry): bool
    {
        return $user->can('view partEntry');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create partEntry') && settings('part_entry_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?PartEntry $partEntry = null): bool
    {
        // First check if user can update any partEntry and a $partEntry has been provided
        if($user->can('update partEntry') && !is_null($partEntry)) {
            // Check that the user is not trying to update a partEntry from another site where the partEntry does not belong to.
            return $partEntry->part->site_id === getPermissionsTeamId();
        }
        return $user->can('update partEntry');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?PartEntry $partEntry = null): bool
    {
        if($user->can('delete partEntry') && !is_null($partEntry)) {
            return $partEntry->part->site_id === getPermissionsTeamId();
        }
        return $user->can('delete partEntry');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export partEntry');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search partEntry');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOtherSite(User $user): bool
    {
        return $user->can('view-other-site partEntry');
    }
}
