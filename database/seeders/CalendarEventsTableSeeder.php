<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarEventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $events = [
            // Selvah
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement Coque',
                'color' => '#f87272',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement PVT',
                'color' => '#33aec1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement Huile',
                'color' => '#f8d20d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Extrusion',
                'color' => '#7839ff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Trituration',
                'color' => '#3abff8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Intervention',
                'color' => '#48f15e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Qualité',
                'color' => '#f000b8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Réunion',
                'color' => '#ddf148',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Extrusel
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'SOJA Huile Brute',
                'color' => '#f87272',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'SOJA Coques',
                'color' => '#33aec1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'SOJA Expellor',
                'color' => '#f8d20d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Huile 1',
                'color' => '#7839ff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Huile 1 ENR',
                'color' => '#3abff8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Huile Brute',
                'color' => '#48f15e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Huile Brute ENR',
                'color' => '#f000b8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Plaquettes',
                'color' => '#ddf148',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'site_id' => 3,
                'name' => 'COLZA Expellor Fines',
                'color' => '#ddf148',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('calendar_events')->insert($events);
    }
}
