<?php

namespace BDS\Observers;

use BDS\Models\Incident;
use Illuminate\Support\Facades\Auth;

class IncidentObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Incident $incident): void
    {
        $incident->user_id = Auth::id();
        $incident->site_id = getPermissionsTeamId();
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Incident $incident): void
    {
        $incident->is_edited = true;
        $incident->edit_count++;
        $incident->edited_user_id = Auth::id();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Incident $incident): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($incident)
                ->event('deleted')
                ->withProperties(['attributes' => $incident->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'incident N°:subject.id.');
        }
    }
}
