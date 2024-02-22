<?php

namespace BDS\Observers;

use BDS\Models\PartEntry;
use Illuminate\Support\Facades\Auth;

class PartEntryObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(PartEntry $partEntry): void
    {
        $partEntry->user_id = Auth::id();
    }
}
