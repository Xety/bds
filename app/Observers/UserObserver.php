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
     * Handle the "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($user)
                ->event('deleted')
                ->withProperties(['attributes' => $user->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'utilisateur :subject.full_name.');
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

    /**
     * Handle the "restored" event.
     */
    public function restored(User $user): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($user)
                ->event('restored')
                ->withProperties(['attributes' => $user->toArray()])
                ->log('L\'utilisateur :causer.full_name à restauré l\'utilisateur :subject.full_name.');
        }
    }
}
