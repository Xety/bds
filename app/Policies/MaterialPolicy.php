<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Material;
use BDS\Models\User;

class MaterialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny material') && settings('material_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Material $material): bool
    {
        if($user->can('view material')) {
            return $material->zone->site_id === getPermissionsTeamId();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create material');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Material $material = null): bool
    {
        // First check if user can update any material and a $material has been provided
        if($user->can('update material') && !is_null($material)) {
            // Check that the user is not trying to update a material from another site where the material does not belong to.
            return $material->zone->site_id === getPermissionsTeamId();
        }
        return $user->can('update material');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Material $material = null): bool
    {
        if($user->can('delete material') && !is_null($material)) {
            return $material->zone->site_id === getPermissionsTeamId();
        }
        return $user->can('delete material');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export material');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search material');
    }

    /**
     * Determine whether the user can generate QrCode for the model.
     */
    public function generateQrCode(User $user): bool
    {
        return $user->can('generate-qrcode material');
    }

    /**
     * Determine whether the user can scan QrCode for the model.
     */
    public function scanQrCode(User $user): bool
    {
        return $user->can('scan-qrcode material');
    }
}
