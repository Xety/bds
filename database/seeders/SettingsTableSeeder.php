<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('settings')->delete();

        \DB::table('settings')->insert(array (
            0 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de connexion',
                'id' => 1,
                'last_updated_user_id' => NULL,
                'name' => 'user.login.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            1 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de création d\'incident.',
                'id' => 2,
                'last_updated_user_id' => NULL,
                'name' => 'incident.create.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            2 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de création de maintenance.',
                'id' => 3,
                'last_updated_user_id' => NULL,
                'name' => 'maintenance.create.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            3 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de création de pièce détachée.',
                'id' => 4,
                'last_updated_user_id' => NULL,
                'name' => 'part.create.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            4 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de création d\'entreprise.',
                'id' => 5,
                'last_updated_user_id' => NULL,
                'name' => 'company.create.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            5 =>
            array (
                'created_at' => '2023-08-15 09:46:15',
                'description' => 'Active/Désactive le système de création de nettoyage.',
                'id' => 6,
                'last_updated_user_id' => NULL,
                'name' => 'cleaning.create.enabled',
                'updated_at' => '2023-08-15 09:46:15',
                'value_bool' => 1,
                'value_int' => NULL,
                'value_str' => NULL,
            ),
            6 =>
                array (
                    'created_at' => '2023-08-15 09:46:15',
                    'description' => 'Quantité de la production livré.',
                    'id' => 7,
                    'last_updated_user_id' => NULL,
                    'name' => 'production.objective.delivered',
                    'updated_at' => '2023-08-15 09:46:15',
                    'value_bool' => NULL,
                    'value_int' => 310270,
                    'value_str' => NULL,
                ),
            7 =>
                array (
                    'created_at' => '2023-08-15 09:46:15',
                    'description' => 'Quantité de production à faire.',
                    'id' => 8,
                    'last_updated_user_id' => NULL,
                    'name' => 'production.objective.todo',
                    'updated_at' => '2023-08-15 09:46:15',
                    'value_bool' => NULL,
                    'value_int' => 715520,
                    'value_str' => NULL,
                ),
        ));


    }
}
