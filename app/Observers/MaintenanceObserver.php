<?php

namespace BDS\Observers;

use BDS\Models\Maintenance;
use Illuminate\Support\Facades\Auth;

class MaintenanceObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Maintenance $maintenance): void
    {
        $maintenance->user_id = Auth::id();
        $maintenance->site_id = getPermissionsTeamId();
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Maintenance $maintenance): void
    {
        $maintenance->is_edited = true;
        $maintenance->edit_count++;
        $maintenance->edited_user_id = Auth::id();
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Maintenance $maintenance): void
    {
        $companies = $maintenance->companies();

        foreach ($companies as $company) {
            $company->maintenances()->detach($maintenance->getKey());
        }
    }
}
