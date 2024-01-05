<?php

namespace BDS\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use BDS\Events\Cleaning\AlertEvent;
use BDS\Models\Material;

class CleaningAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleaning:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi une alerte aux utilisateurs prédéfinis sur les nettoyages non effectués par rapport au plan de nettoyage.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $materials = Material::where('cleaning_alert', true)->get();

        // Filter only the expired cleaning.
        $cleaningsExpired = $materials->filter(function ($material) {
            $days = config('selvah.cleaning.multipliers.' . $material->cleaning_alert_frequency_type) * $material->cleaning_alert_frequency_repeatedly;

            // If the last cleaning at is null that mean there's no cleaning at all, so return directly true.
            if ($material->last_cleaning_at === null) {
                return true;
            }

            // Check if the last cleaning is expired regarding the current time - the cleaning frequency.
            return $material->last_cleaning_at <= now()->subDays($days);
        });

        // Send the Event
        $cleaningsExpired->each(function ($material) {
            // Check the last alert notification to prevent notification spam
            if ($material->last_cleaning_alert_send_at >= now()->subHours(config('selvah.cleaning.send_alert_frequency'))) {
                return;
            }

            event(new AlertEvent($material));
        });
    }
}
