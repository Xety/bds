<?php

namespace BDS\Observers;

use BDS\Models\Company;
use Illuminate\Support\Facades\Auth;
use BDS\Models\Material;

class CompanyObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Company $company): void
    {
        $company->user_id = Auth::id();
        $company->site_id = getPermissionsTeamId();
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Company $company): void
    {
        $maintenances = $company->maintenances;

        foreach ($maintenances as $maintenance) {
            $maintenance->companies()->detach($company->getKey());
        }


    }
}
