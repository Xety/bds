<?php

namespace BDS\Observers;

use BDS\Models\PartEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PartEntryObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(PartEntry $partEntry): void
    {
        $partEntry->user_id = Auth::id();
    }

    /**
     * Handle the "deleting" event.
     *
     * @param PartEntry $partEntry The model to delete.
     *
     * @return bool
     */
    public function deleting(PartEntry $partEntry): bool
    {
        // We need to check that the deleted partEntry won't make the stock in negative.
        if (($partEntry->part->stock_total - $partEntry->number) < 0) {
            Session::flash('delete.error', 'Vous ne pouvez pas supprimer une entrée qui mettrait le stock en négatif !');

            return false;
        }

        return true;
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(PartEntry $partEntry): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($partEntry)
                ->event('deleted')
                ->withProperties(['attributes' => $partEntry->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'entré N°:subject.id de pièce détachée ' . $partEntry->part->name. '.');
        }
    }
}
