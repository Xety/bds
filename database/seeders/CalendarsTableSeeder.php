<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarsTableSeeder extends Seeder
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
                'id' => '7c6a6561-72c5-4113-a5d8-aba3fc797722',
                'user_id' => 1,
                'site_id' => 2,
                'calendar_event_id' => 1,
                'title' => 'AGIS TARARE',
                'color' => '#f87272',
                'allDay' => 1,
                'status' => 'waiting',
                'started' => '2024-03-06 00:00:00',
                'ended' => '2024-03-07 00:00:00'
            ],
            [
                'id' => '7c6a6561-72c5-4113-a5d8-aba3fc797723',
                'user_id' => 1,
                'site_id' => 3,
                'calendar_event_id' => 12,
                'title' => 'Feed Alliance',
                'color' => '#f87272',
                'allDay' => 1,
                'status' => 'done',
                'started' => '2024-02-29 00:00:00',
                'ended' => '2024-03-01 00:00:00'
            ],
            [
            'id' => '7c6a6561-72c5-4113-a5d8-aba3fc797724',
            'user_id' => 2,
            'site_id' => 3,
            'calendar_event_id' => 13,
            'title' => 'Feed Alliance',
            'color' => '#f87272',
            'allDay' => 1,
            'status' => 'incoming',
            'started' => '2024-03-05 00:00:00',
            'ended' => '2024-03-06 00:00:00'
        ]
        ];

        DB::table('calendars')->insert($events);
    }
}
