<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule
Schedule::command('users:deactivate')->everyFifteenMinutes();

if (\Illuminate\Support\Facades\App::environment() == 'production') {
    // Backup Database
    /*$schedule->command('backup:clean')->daily()->at('01:00');
    $schedule->command('backup:run')->daily()->at('01:30');*/

    // Cleaning Alerts
    //$schedule->command('cleaning:alert')->everyFifteenMinutes();
}
