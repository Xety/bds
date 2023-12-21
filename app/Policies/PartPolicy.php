<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Part;
use BDS\Models\User;

class PartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny part') && settings('part_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Part $part): bool
    {
        if($user->can('view part')) {
            return $part->site_id === getPermissionsTeamId();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create part');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Part $part = null): bool
    {
        // First check if user can update any part and a $part has been provided
        if($user->can('update part') && !is_null($part)) {
            // Check that the user is not trying to update a part from another site where the part does not belong to.
            return $part->site_id === getPermissionsTeamId();
        }
        return $user->can('update part');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Part $part = null): bool
    {
        if($user->can('delete part') && !is_null($part)) {
            return $part->site_id === getPermissionsTeamId();
        }
        return $user->can('delete part');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export part');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search part');
    }

    /**
     * Determine whether the user can generate QrCode for the model.
     */
    public function generateQrCode(User $user): bool
    {
        return $user->can('generate-qrcode part');
    }

    /**
     * Determine whether the user can scan QrCode for the model.
     */
    public function scanQrCode(User $user): bool
    {
        return $user->can('scan-qrcode part');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOtherSite(User $user): bool
    {
        return $user->can('view-other-site part');
    }
}
