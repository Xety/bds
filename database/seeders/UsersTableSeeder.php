<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $users = [
            [
                'username' => 'Emeric.F',
                'first_name' => 'Emeric',
                'last_name' => 'Fevre',
                'email' => 'e.fevre@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 1,
                'cleaning_count' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'Christophe.G',
                'first_name' => 'Christophe',
                'last_name' => 'Gateau',
                'email' => 'c.gateau@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 2,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'Fabrice.R',
                'first_name' => 'Fabrice',
                'last_name' => 'Rossignol',
                'email' => 'f.rossignol@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 3,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'JeanMichel.B',
                'first_name' => 'JeanMichel',
                'last_name' => 'Briset',
                'email' => 'jm.briset@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 3,
                'cleaning_count' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'Anthony.M',
                'first_name' => 'Anthony',
                'last_name' => 'Moindrot',
                'email' => 'a.moindrot@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 2,
                'cleaning_count' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'Alexis.B',
                'first_name' => 'Alexis',
                'last_name' => 'Bert',
                'email' => 'a.bert@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 2,
                'cleaning_count' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'Charline.B',
                'first_name' => 'Charline',
                'last_name' => 'Brocot',
                'email' => 'c.brocot@bds.coop',
                'password' => bcrypt('password'),
                'current_site_id' => 2,
                'cleaning_count' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('users')->insert($users);
    }
}
