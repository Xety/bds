<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            [
                'id' => 1,
                'site_id'=> 2,
                'name' => 'Barreau',
                'description' => 'Barreau de presse',
                'user_id' => 1,
                'reference' => '123456',
                'supplier_id' => 1,
                'price' => 10.56,
                'part_entry_total' => 10,
                'part_exit_total' => 5,
                'number_warning_enabled' => 0,
                'number_warning_minimum' => 0,
                'number_critical_enabled' => 0,
                'number_critical_minimum' => 0,
                'part_entry_count' => 1,
                'part_exit_count' => 1,
                'material_count' => 10,
                'qrcode_flash_count' => 1,
                'edit_count' => 0,
                'is_edited' => 0,
                'edited_user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'site_id'=> 3,
                'name' => 'Barreau',
                'description' => 'Barreau de presse',
                'user_id' => 1,
                'reference' => '123456',
                'supplier_id' => 8,
                'price' => 10.56,
                'part_entry_total' => 0,
                'part_exit_total' => 0,
                'number_warning_enabled' => 0,
                'number_warning_minimum' => 0,
                'number_critical_enabled' => 0,
                'number_critical_minimum' => 0,
                'part_entry_count' => 0,
                'part_exit_count' => 0,
                'material_count' => 1,
                'qrcode_flash_count' => 0,
                'edit_count' => 0,
                'is_edited' => 0,
                'edited_user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('parts')->insert($parts);
    }
}
