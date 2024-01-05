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
                'name' => 'Toy',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Denis',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Kongskilde',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Olexa',
                'description' => '',
                'maintenance_count' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Bourgogne du Sud Maintenance',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'name' => 'SGN Élec',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'name' => 'Clextral',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'name' => 'Orreca',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'name' => 'AFCE',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'name' => 'SoluFood',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'name' => 'Vit Élec',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'name' => 'Dégottex',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 13,
                'name' => 'Bourgogne Automatisme',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 14,
                'name' => 'Viessmann',
                'description' => '',
                'maintenance_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 15,
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
