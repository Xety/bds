<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartsUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $partsUsers = [
            [
                'part_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'part_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('part_user')->insert($partsUsers);
    }
}
