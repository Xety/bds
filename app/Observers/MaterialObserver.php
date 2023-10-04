<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\Material;

class MaterialObserver
{
    /**
     * Handle the Material "creating" event.
     */
    public function creating(Material $material): void
    {
        $material->user_id = Auth::id();
    }
}
