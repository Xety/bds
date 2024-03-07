<?php
namespace BDS\Policies;

use BDS\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Supplier;
use BDS\Models\User;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny company') && settings('company_manage_enabled', true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        if($user->can('view company')) {
            $siteId = getPermissionsTeamId();
            return ($company->site_id === $siteId || $siteId === settings('site_id_verdun_siege'));
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create company') && settings('company_create_enabled', true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Company $company = null): bool
    {
        if($user->can('update company') && !is_null($company)) {
            return $company->site_id === getPermissionsTeamId();
        }
        return $user->can('update company');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?Company $company = null): bool
    {
        if($user->can('delete company') && !is_null($company)) {
            return $company->site_id === getPermissionsTeamId();
        }
        return $user->can('delete company');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export company');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search company');
    }
}
