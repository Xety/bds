<?php

namespace BDS\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
//use Selvah\Events\Cleaning\AlertEvent;
use BDS\Models\User;

class UsersDeactivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Désactive les comptes utilisateurs si la date de fin de contrat est arrivée à expiration.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get all the users that have an employment contract expiration and are not yet deleted.
        $usersExpired = User::where('end_employment_contract', '<', now())
            ->whereNull('deleted_at')
            ->get();

        // Soft delete the users
        $usersExpired->each(function ($user) {
            $user->delete();
        });
    }
}
