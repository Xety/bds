<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $materialsUsers = [
            [
                'material_id' => 74,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 74,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 75,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 75,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 76,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 76,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 80,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 80,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 83,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 83,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 84,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 84,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 85,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 85,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 87,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 87,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 88,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 88,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 93,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 93,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 94,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 94,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 95,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 95,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 101,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 101,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 102,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 102,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 106,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 106,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 115,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 115,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 122,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 122,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 123,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 123,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 137,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'material_id' => 137,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('material_user')->insert($materialsUsers);
    }
}
