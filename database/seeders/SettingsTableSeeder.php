<?php

namespace Database\Seeders;

use BDS\Models\Setting;
use BDS\Models\Site;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Settings without site assigned to.
        Setting::create([
            'key' => 'user.login.enabled',
            'site_id' => null,
            'value' => true,
            'description' => 'Active/Désactive le système de connexion.'
        ]);
        Setting::create([
            'key' => 'site.create.enabled',
            'site_id' => null,
            'value' => true,
            'description' => 'Active/Désactive le système de création de site.'
        ]);

        // Settings for all sites except Verdun Siège.
        for ($i = 2; $i < 52; $i++) {
            Setting::create([
                'key' => 'zone.create.enabled',
                'site_id' => $i,
                'value' => true,
                'description' => 'Active/Désactive le système de création de zone.'
            ]);
            Setting::create([
                'key' => 'cleaning.create.enabled',
                'site_id' => $i,
                'value' => true,
                'description' => 'Active/Désactive le système de création de nettoyage.'
            ]);
        }

        // Setting for Selvah
        $selvah = Site::where('name', 'Selvah')->first();
        Setting::create([
            'key' => 'production.objective.delivered',
            'site_id' => $selvah->id,
            'value' => 310270,
            'description' => 'Quantité de la production livré.'
        ]);
        Setting::create([
            'key' => 'production.objective.todo',
            'site_id' => $selvah->id,
            'value' => 715520,
            'description' => 'Quantité de production à faire.'
        ]);

    }
}
