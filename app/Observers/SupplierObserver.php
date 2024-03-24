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

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($supplier)
                ->event('deleted')
                ->withProperties(['attributes' => $supplier->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé le fournisseur :subject.name.');
        }
    }
}
