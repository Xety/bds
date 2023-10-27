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
        return $user->can('viewAny material');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Material $material): bool
    {
        return $user->can('view material');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export material');
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
    public function update(User $user): bool
    {
        // Give update access to all materials, remove to only allow created material,
        // false to not allow any update.
        return $user->can('update material');

        //return $user->id === $material->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete material');
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
