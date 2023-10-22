<?php

namespace Database\Seeders;

use BDS\Models\Setting;
use BDS\Models\Site;
use BDS\Models\User;
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
            'key' => 'app_login_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de connexion.',
            'text' => 'Active/Désactive le système de connexion.',
            'label_info' => 'Cocher pour activer le système de connexion au site. <br><b>Quand le système de connexion est désactivé, uniquement les personnes disposant de la permission direct <code class="text-neutral-content bg-neutral rounded-sm py-0.5 px-2">bypass login</code> pourront se connecter.</b>'
        ]);
        Setting::create([
            'key' => 'site_create_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de création de site.',
            'text' => 'Active/Désactive le système de création de site.',
            'label_info' => ''
        ]);

        Setting::create([
            'key' => 'user_notification_email',
            'site_id' => null,
            'value' => true,
            'model_type' => User::class,
            'model_id' => 1,
            'text' => 'Active/Désactive les notifications par email.'
        ]);

        // Settings for all sites except Verdun Siège.
        for ($i = 2; $i < 52; $i++) {
            Setting::create([
                'key' => 'zone_create_enabled',
                'site_id' => $i,
                'value' => true,
                'label' => 'Activation du système de création de zone.',
                'text' => 'Active/Désactive le système de création de zone.'
            ]);
            Setting::create([
                'key' => 'cleaning_create_enabled',
                'site_id' => $i,
                'value' => true,
                'label' => 'Activation du système de création de nettoyage.',
                'text' => 'Active/Désactive le système de création de nettoyage.'
            ]);
        }

        // Setting for Selvah
        $selvah = Site::where('name', 'Selvah')->first();
        Setting::create([
            'key' => 'production_objective_delivered',
            'site_id' => $selvah->id,
            'value' => 310270,
            'text' => 'Quantité de la production livré.',
            'label' => 'Quantité de la production livré.'
        ]);
        Setting::create([
            'key' => 'production_objective_todo',
            'site_id' => $selvah->id,
            'value' => 715520,
            'text' => 'Quantité de production à faire.',
            'label' => 'Quantité de production à faire.'
        ]);

    }
}
