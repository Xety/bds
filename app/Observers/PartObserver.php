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
}
