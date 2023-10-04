<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        $now = now();

        $zones = [
            // Beaune
            [
                'name' => '1970',
                'site_id' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '1980',
                'site_id' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '1992',
                'site_id' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Chalon Nord
            [
                'name' => '1960',
                'site_id' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '2001',
                'site_id' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '2010',
                'site_id' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Séchoirs 2015',
                'site_id' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('zones')->insert($zones);

    }
}
