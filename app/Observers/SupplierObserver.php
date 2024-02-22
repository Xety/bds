<?php

namespace BDS\Observers;

use BDS\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Supplier $part): void
    {
        $part->user_id = Auth::id();
        $part->site_id = getPermissionsTeamId();
    }
}
