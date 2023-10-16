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
                'level' => 100,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 2,
                'name' => 'Responsable Selvah',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 3,
                'name' => 'Responsable Adjoint Selvah',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#5ccc5c',
                'description' => NULL,
                'level' => 40,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 4,
                'name' => 'Assistant(e) Qualité',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ffca00',
                'description' => NULL,
                'level' => 30,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 5,
                'name' => 'Opérateur',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'level' => 20,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 6,
                'name' => 'Saisonnier',
                'created_at' => '2023-08-15 09:46:14',
                'color' => null,
                'description' => NULL,
                'level' => 10,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 7,
                'name' => 'Responsable Extrusel',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
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
                'level' => 40,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 9,
                'name' => 'Responsable Beaune',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 10,
                'name' => 'Responsable Bligny sur Ouche',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 11,
                'name' => 'Responsable Gergy',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 12,
                'name' => 'Responsable Meursanges',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 13,
                'name' => 'Responsable Chalon Nord',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
            array (
                'id' => 14,
                'name' => 'Responsable Crissey',
                'created_at' => '2023-08-15 09:46:14',
                'color' => '#ef9a3c',
                'description' => NULL,
                'level' => 50,
                'guard_name' => 'web',
                'updated_at' => '2023-08-15 09:46:14',
            ),
        ));
    }
}
