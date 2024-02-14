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
}
