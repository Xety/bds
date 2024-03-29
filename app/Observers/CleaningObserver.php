<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\Cleaning;
use BDS\Models\Material;

class CleaningObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Cleaning $cleaning): void
    {
        $cleaning->user_id = Auth::id();
        $cleaning->site_id = getPermissionsTeamId();
    }

    /**
     * Handle the "created" event.
     */
    public function created(Cleaning $cleaning): void
    {
        $material = Material::find($cleaning->material_id);
        $material->last_cleaning_at = now();
        $material->save();
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Cleaning $cleaning): void
    {
        $cleaning->is_edited = true;
        $cleaning->edit_count++;
        $cleaning->edited_user_id = Auth::id();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Cleaning $cleaning): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($cleaning)
                ->event('deleted')
                ->withProperties(['attributes' => $cleaning->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé le nettoyage N°:subject.id.');
        }
    }
}
