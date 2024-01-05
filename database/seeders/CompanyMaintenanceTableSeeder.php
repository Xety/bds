<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyMaintenanceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $companiesMaintenances = [
            [
                'company_id' => 4,
                'maintenance_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('company_maintenance')->insert($companiesMaintenances);
    }
}
