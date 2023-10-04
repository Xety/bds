<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            [
                'name' => 'Siège Verdun',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Beaune',
                'zone_count' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chalon Nord',
                'zone_count' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Crissey',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('sites')->insert($sites);
    }
}
