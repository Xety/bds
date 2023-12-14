<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'site_id' => 2,
                'name' => 'OLEXA',
                'description' => null,
                'part_count' => 1
            ],
            [
                'site_id' => 2,
                'name' => 'CLEXTRAL',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 2,
                'name' => 'FISCHBEIN',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 2,
                'name' => 'TOY',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 2,
                'name' => 'CONDAT',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 11,
                'name' => 'RAVEY',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 5,
                'name' => 'RAVEY',
                'description' => null,
                'part_count' => 0
            ],
            [
                'site_id' => 3,
                'name' => 'OLEXA',
                'description' => null,
                'part_count' => 1
            ],
        ];


        DB::table('suppliers')->insert($suppliers);
    }
}
