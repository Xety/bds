<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'id' => 1,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Toy',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Denis',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Kongskilde',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Olexa',
                'description' => '',
                'maintenance_count' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Bourgogne du Sud Maintenance',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'SGN Élec',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Clextral',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Orreca',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'AFCE',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'SoluFood',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Vit Élec',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Dégottex',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 13,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Bourgogne Automatisme',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 14,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Viessmann',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 15,
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Fitech',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('companies')->insert($companies);
    }
}
