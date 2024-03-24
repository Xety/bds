<?php

namespace BDS\Observers;

use BDS\Models\Company;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Company $company): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($company)
                ->event('deleted')
                ->withProperties(['attributes' => $company->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'entreprise :subject.name.');
        }
    }
}
