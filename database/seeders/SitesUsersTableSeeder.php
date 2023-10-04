<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            // Emeric
            [
                'user_id' => 1,
                'site_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'site_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Christophe
            [
                'user_id' => 2,
                'site_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Fabrice
            [
                'user_id' => 3,
                'site_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'site_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // JeanMichel
            [
                'user_id' => 4,
                'site_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'site_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Anthony
            [
                'user_id' => 5,
                'site_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Alexis
            [
                'user_id' => 6,
                'site_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Charline
            [
                'user_id' => 7,
                'site_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 7,
                'site_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 7,
                'site_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('site_user')->insert($sites);
    }
}
