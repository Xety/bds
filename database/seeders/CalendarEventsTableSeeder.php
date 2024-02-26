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
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement Coque',
                'color' => '#f87272'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement PVT',
                'color' => '#33aec1'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Chargement Huile',
                'color' => '#f8d20d'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Extrusion',
                'color' => '#7839ff'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Trituration',
                'color' => '#3abff8'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Intervention',
                'color' => '#48f15e'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Qualité',
                'color' => '#f000b8'
            ],
            [
                'user_id' => 1,
                'site_id' => 2,
                'name' => 'Réunion',
                'color' => '#ddf148'
            ],
        ];

        DB::table('calendar_events')->insert($events);
    }
}
