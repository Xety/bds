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
}
