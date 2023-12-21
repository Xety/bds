<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $partEntries = [
           [
               'part_id' => 1,
               'user_id' => 1,
               'number' => 10,
               'order_id'=> '123456',
               'created_at' => now(),
               'updated_at' => now(),
           ]
        ];

        DB::table('part_entries')->insert($partEntries);
    }
}
