<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsPartsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $materialsParts = [
            [
                'material_id' => 42,
                'part_id' => 1
            ],
            [
                'material_id' => 43,
                'part_id' => 1
            ],
            [
                'material_id' => 44,
                'part_id' => 1
            ],
            [
                'material_id' => 45,
                'part_id' => 1
            ],
            [
                'material_id' => 46,
                'part_id' => 1
            ],
            [
                'material_id' => 47,
                'part_id' => 1
            ],
            [
                'material_id' => 48,
                'part_id' => 1
            ],
            [
                'material_id' => 49,
                'part_id' => 1
            ],
            [
                'material_id' => 50,
                'part_id' => 1
            ],
            [
                'material_id' => 51,
                'part_id' => 1
            ],
            [
                'material_id' => 141,
                'part_id' => 2
            ],
        ];

        DB::table('material_part')->insert($materialsParts);
    }
}
