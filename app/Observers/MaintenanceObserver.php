<?php

namespace BDS\Observers;

use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\PartExit;
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
        // Detach all related companies.
        $companies = $maintenance->companies;
        foreach ($companies as $company) {
            $company->maintenances()->detach($maintenance->getKey());
        }

        // Detach all related operators.
        $operators = $maintenance->operators;
        foreach ($operators as $operator) {
            $operator->maintenancesOperators()->detach($maintenance->getKey());
        }

        // Unassigned the maintenance_id for all related incidents.
        $existingIds = $maintenance->incidents()->pluck('id')->toArray();
        Incident::whereIn('id', $existingIds)->update(['maintenance_id' => null]);

        // Unassigned the maintenance_id for all related partExits.
        $existingIds = $maintenance->partExits()->pluck('id')->toArray();
        PartExit::whereIn('id', $existingIds)->update(['maintenance_id' => null]);
    }
}
