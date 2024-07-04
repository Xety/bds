<?php

namespace BDS\Observers;

use BDS\Models\Cleaning;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use BDS\Models\Material;

class MaterialObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Material $material): void
    {
        $material->user_id = Auth::id();
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Material $material): void
    {
        // Detach all parts related to the material
        $parts = $material->parts;
        foreach ($parts as $part) {
            $part->materials()->detach($material->getKey());
        }

        // Delete all incidents related to the material
        Incident::destroy($material->incidents->pluck('id')->toArray());

        // Delete all maintenances related to the material
        Maintenance::destroy($material->maintenances->pluck('id')->toArray());

        // Delete all cleanings related to the material
        Cleaning::destroy($material->cleanings->pluck('id')->toArray());
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Material $material): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($material)
                ->event('deleted')
                ->withProperties(['attributes' => $material->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé le matériel :subject.name.');
        }
    }
}
