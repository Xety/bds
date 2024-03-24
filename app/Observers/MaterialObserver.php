<?php

namespace BDS\Observers;

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
        $parts = $material->parts;

        foreach ($parts as $part) {
            $part->materials()->detach($material->getKey());
        }
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
