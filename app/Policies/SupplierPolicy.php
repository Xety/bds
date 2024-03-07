<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Supplier;
use BDS\Models\User;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny supplier') && settings('supplier_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        if($user->can('view supplier')) {
            $siteId = getPermissionsTeamId();
            return ($supplier->site_id === $siteId || $siteId === settings('site_id_verdun_siege'));
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create supplier') && settings('supplier_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Supplier $supplier = null): bool
    {
        if($user->can('update supplier') && !is_null($supplier)) {
            return $supplier->site_id === getPermissionsTeamId();
        }
        return $user->can('update supplier');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?Supplier $supplier = null): bool
    {
        if($user->can('delete supplier') && !is_null($supplier)) {
            return $supplier->site_id === getPermissionsTeamId();
        }
        return $user->can('delete supplier');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export supplier');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search supplier');
    }
}
