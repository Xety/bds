<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\Part;

class PartObserver
{
    /**
     * Handle the Part "creating" event.
     */
    public function creating(Part $part): void
    {
        $part->user_id = Auth::id();
        $part->site_id = getPermissionsTeamId();
    }

    public function deleting(Part $part): void
    {
        $materials = $part->materials;

        foreach ($materials as $material) {
            $material->parts()->detach($part->getKey());
        }

    }
}
