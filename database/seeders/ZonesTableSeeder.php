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
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 1,
                'material_count' => 21,
                'name' => 'Broyage',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 2,
                'material_count' => 48,
                'name' => 'Trituration',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 3,
                'material_count' => 32,
                'name' => 'Extrusion',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 4,
                'material_count' => 7,
                'name' => 'Recyclage des fines',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 5,
                'material_count' => 15,
                'name' => 'Ensachage',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 6,
                'material_count' => 3,
                'name' => 'Station vidange BigBag',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 7,
                'material_count' => 6,
                'name' => 'Station remplissage BigBag',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 8,
                'material_count' => 5,
                'name' => 'Autre',
                'parent_id' => null,
                'site_id' => 2,
                'updated_at' => '2023-08-09 22:02:34',
            ),

            // Extrusel
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 9,
                'material_count' => 0,
                'name' => 'Usine 1',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 10,
                'material_count' => 0,
                'name' => '1 ère Pression',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 11,
                'material_count' => 0,
                'name' => '2 ème Pression',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 12,
                'material_count' => 0,
                'name' => 'Conditionneur',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 13,
                'material_count' => 0,
                'name' => 'Ecailles',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 14,
                'material_count' => 0,
                'name' => 'Extraction Colza',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 15,
                'material_count' => 0,
                'name' => 'Filtration 1 ère Pression',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 16,
                'material_count' => 0,
                'name' => 'Filtration 2 ème Pression',
                'parent_id' => 9,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 17,
                'material_count' => 0,
                'name' => 'Usine 2',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 18,
                'material_count' => 0,
                'name' => 'Usine 3',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 19,
                'material_count' => 0,
                'name' => 'Local Désodorisation',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 20,
                'material_count' => 0,
                'name' => 'Degommage',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 21,
                'material_count' => 0,
                'name' => 'Chaufferies',
                'parent_id' => null,
                'site_id' => 3,
                'updated_at' => '2023-08-09 22:02:34',
            ),

            // Chalon Nord
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 22,
                'material_count' => 0,
                'name' => 'Silos',
                'parent_id' => null,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 23,
                'material_count' => 0,
                'name' => 'Silo 1971',
                'parent_id' => 22,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 24,
                'material_count' => 0,
                'name' => 'Silo 1973',
                'parent_id' => 22,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 25,
                'material_count' => 1,
                'name' => 'Boisseau B1',
                'parent_id' => 23,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 26,
                'material_count' => 0,
                'name' => 'Boisseau B2',
                'parent_id' => 23,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 27,
                'material_count' => 0,
                'name' => 'Séchoirs',
                'parent_id' => null,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 28,
                'material_count' => 0,
                'name' => 'Séchoir 2015 A',
                'parent_id' => 27,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
            array (
                'created_at' => '2023-08-09 22:02:34',
                'id' => 29,
                'material_count' => 0,
                'name' => 'Séchoir 2015 B',
                'parent_id' => 27,
                'site_id' => 11,
                'updated_at' => '2023-08-09 22:02:34',
            ),
        ));


    }
}
