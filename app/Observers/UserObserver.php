<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\User;

class UserObserver
{
    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        if (auth()->user()) {
            $user->deleted_user_id = Auth::id();
            $user->save();
        }
    }

    /**
     * Handle the User "restoring" event.
     */
    public function restoring(User $user): void
    {
        $user->deleted_user_id = null;
        $user->save();
    }
}
