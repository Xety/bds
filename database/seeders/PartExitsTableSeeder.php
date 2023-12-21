<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartExitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $partExits = [
           [
               'maintenance_id' => null,
               'part_id' => 1,
               'user_id' => 1,
               'description'=> null,
               'number' => 5,
               'created_at' => now(),
               'updated_at' => now(),
           ]
        ];

        DB::table('part_exits')->insert($partExits);
    }
}
