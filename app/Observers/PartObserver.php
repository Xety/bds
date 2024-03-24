<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\Part;

class PartObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Part $part): void
    {
        $part->user_id = Auth::id();
        $part->site_id = getPermissionsTeamId();
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Part $part): void
    {
        $materials = $part->materials;

        foreach ($materials as $material) {
            $material->parts()->detach($part->getKey());
        }
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Part $part): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($part)
                ->event('deleted')
                ->withProperties(['attributes' => $part->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé la pièce détachée :subject.name.');
        }
    }
}
