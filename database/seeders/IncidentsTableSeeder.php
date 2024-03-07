<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $incidents = [
            [
                'id' => 1,
                'site_id' => 2,
                'maintenance_id' => 1,
                'material_id' => 46,
                'user_id' => 1,
                'description' => 'Rupture de l\'écrou de serrage des profils de vis.',
                'started_at' => '2023-02-22 22:02:34',
                'impact' => 'critique',
                'is_finished' => true,
                'finished_at' => '2023-06-15 22:02:34',
                'edit_count' => 0,
                'is_edited' => 0,
                'edited_user_id' => NULL,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('incidents')->insert($incidents);
    }
}
