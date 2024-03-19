<?php

namespace BDS\Observers;

use Illuminate\Support\Facades\Auth;
use BDS\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /*activity()
            ->performedOn($user)
            ->event('created')
            ->log('L\'utilisateur :causer.full_name à créer l\'utilisateur :subject.full_name.');*/
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        /*activity()
            ->performedOn($user)
            ->event('updated')
            ->withProperties($user)
            ->log('L\'utilisateur :causer.full_name à mis à jour l\'utilisateur :subject.full_name.');*/
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
