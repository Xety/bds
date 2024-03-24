<?php

namespace BDS\Observers;

use BDS\Models\PartExit;
use Illuminate\Support\Facades\Auth;

class PartExitObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(PartExit $partExit): void
    {
        $partExit->user_id = Auth::id();
        $partExit->price = $partExit->part->price;
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(PartExit $partExit): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($partExit)
                ->event('deleted')
                ->withProperties(['attributes' => $partExit->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé la sortie N°:subject.id de pièce détachée ' . $partExit->part->name. '.');
        }
    }
}
