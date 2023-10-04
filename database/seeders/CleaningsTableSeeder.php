<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleaningsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $cleanings = [
            [
                'user_id' => 2,
                'material_id' => 1,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 5,
                'material_id' => 2,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'user_id' => 3,
                'material_id' => 3,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'material_id' => 4,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('cleanings')->insert($cleanings);
    }
}
