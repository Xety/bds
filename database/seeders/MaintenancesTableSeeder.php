<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenancesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $maintenances = [
            [
                'id' => 1,
                'site_id' => 2,
                'gmao_id' => NULL,
                'material_id' => 46,
                'description' => 'Démonté la presse (Franck et Alexis), changé les barreaux (OLEXA), puis remonté la presse (Franck, Emeric).',
                'reason' => 'Problème d\'écrou de serrage des profils de vis.',
                'user_id' => 1,
                'type' => 'curative',
                'realization' => 'both',
                'started_at' => '2023-06-08 22:02:34',
                'is_finished' => false,
                'finished_at' => null,
                'incident_count' => 1,
                'edit_count' => 0,
                'is_edited' => 0,
                'edited_user_id' => NULL,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('maintenances')->insert($maintenances);
    }
}
