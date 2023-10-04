<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MaterialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $materials = [
            [
                'user_id' => 1,
                'name' => 'EL1',
                'description' => 'Elevateur n°1.',
                'zone_id' => 2,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 1,
                'name' => 'EL2',
                'description' => 'Elevateur n°2.',
                'zone_id' => 3,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            [
                'user_id' => 1,
                'name' => 'TC1',
                'description' => 'Transporteur n°1.',
                'zone_id' => 4,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 1,
                'name' => 'TC2',
                'description' => 'Transporteur n°2.',
                'zone_id' => 5,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('materials')->insert($materials);
    }
}
