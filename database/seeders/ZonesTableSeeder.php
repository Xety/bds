<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('zones')->delete();

        \DB::table('zones')->insert(array (
            0 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 1,
                'material_count' => 21,
                'name' => 'Broyage',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            1 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 2,
                'material_count' => 48,
                'name' => 'Trituration',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            2 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 3,
                'material_count' => 32,
                'name' => 'Extrusion',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            3 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 4,
                'material_count' => 7,
                'name' => 'Recyclage des fines',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            4 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 5,
                'material_count' => 15,
                'name' => 'Ensachage',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            5 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 6,
                'material_count' => 3,
                'name' => 'Station vidange BigBag',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            6 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 7,
                'material_count' => 6,
                'name' => 'Station remplissage BigBag',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            7 =>
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 8,
                'material_count' => 5,
                'name' => 'Autre',
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
        ));


    }
}
