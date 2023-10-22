<?php

namespace BDS\Observers;

use BDS\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingObserver
{

    /**
     * Handle the Cleaning "created" event.
     */
    public function created(Cleaning $cleaning): void
    {

        $material = Material::find($cleaning->material_id);
        $material->last_cleaning_at = now();
        $material->save();
    }

    /**
     * Handle the Cleaning "updating" event.
     */
    public function updating(Cleaning $cleaning): void
    {
        $cleaning->is_edited = true;
        $cleaning->edit_count++;
        $cleaning->edited_user_id = Auth::id();
    }
}
