<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert(array (
            array (
                'id' => 1,
                'name' => 'Développeur',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#14e8e1',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 100,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 2,
                'name' => 'Directeur Général',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef3c3c',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 90,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 3,
                'name' => 'Directeur Général Adjoint',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef3c3c',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 90,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 4,
                'name' => 'Responsable Selvah',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'site_id' => 2,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 5,
                'name' => 'Responsable Adjoint Selvah',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#5ccc5c',
                'description' => NULL,
                'site_id' => 2,
                'level' => 40,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 6,
                'name' => 'Opérateur Selvah',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'site_id' => 2,
                'level' => 20,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 7,
                'name' => 'Responsable Extrusel',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'site_id' => 3,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 8,
                'name' => 'Responsable Adjoint Extrusel',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#5ccc5c',
                'description' => NULL,
                'site_id' => 3,
                'level' => 40,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 9,
                'name' => 'Opérateur Extrusel',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'site_id' => 3,
                'level' => 20,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 10,
                'name' => 'Responsable Silo',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 11,
                'name' => 'Responsable Qualité',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 12,
                'name' => 'Assistant(e) Qualité Filiale',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ffca00',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 30,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 13,
                'name' => 'Assistant(e) Qualité Bourgogne du Sud',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ffca00',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 30,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 14,
                'name' => 'Saisonnier Bourgogne du Sud',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'site_id' => NULL,
                'level' => 10,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 15,
                'name' => 'Responsable Maintenance',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'site_id' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 16,
                'name' => 'Opérateur Maintenance',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'site_id' => NULL,
                'level' => 20,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
        ));
    }
}
