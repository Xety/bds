<?php

namespace Database\Seeders;

use BDS\Models\Site;
use Illuminate\Database\Seeder;
use Rawilk\Settings\Facades\Settings;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Settings for all sites.
        for ($i = 1; $i < 52; $i++) {
            Settings::setTeamId($i)->set('cleaning.create.enabled', true);
        }

        // Setting for Selvah
        $selvah = Site::where('name', 'Selvah')->first();
        Settings::setTeamId($selvah->id)->set('production.objective.delivered', '310270');
        Settings::setTeamId($selvah->id)->set('production.objective.todo', '715520');

    }
}
