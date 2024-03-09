<?php

namespace BDS\Observers;

use BDS\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Supplier $supplier): void
    {
        $supplier->user_id = Auth::id();
        $supplier->site_id = getPermissionsTeamId();
    }
}
