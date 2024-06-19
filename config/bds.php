<?php

use Carbon\Carbon;

return [
    /*
    |--------------------------------------------------------------------------
    | Informations
    |--------------------------------------------------------------------------
    |
    | All informations related to the site.
    */
    'info' => [
        'full_name' => 'Coopérative Bourgogne du Sud',
        'site_description' => 'Site de gestion interne de la Coopérative Bourgogne du Sud et ces filiales.'
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | All cache options in seconds.
    */
    'cache' => [
        //Dashboard
        'incidents_count' => 3600,
        'maintenances_count' => 3600,
        'parts_count' => 3600,
        'cleanings_count' => 3600,
        'graph_maintenance_incident' => 3600,
        'graph_part_entries_part_exits' => 3600,
        'weather_timeout' => 600, // 10 min

        // Parts
        'parts' => [
            'price_total_all_part_in_stock' => 3600, // 1 hour
            'price_total_all_part_exits' => 3600,
            'price_total_all_part_entries' => 3600,
            'total_part_in_stock' => 3600,
            'total_part_out_of_stock' => 3600,
            'total_part_get_in_stock' => 3600,
            'part_entries_part_exits_count_last_12_months' => 3600
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | All pagination settings used to paginate the queries.
    */
    'pagination' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Cleaning
    |--------------------------------------------------------------------------
    |
    | All cleaning settings used in application.
    */
    'cleaning' => [
        // The frequency in hours used to send the notifications and emails for cleaning alert.
        'send_alert_frequency' => 24,
        'multipliers' => [
            'daily' => 1,
            'monthly' => Carbon::now()->daysInMonth,
            'yearly' => Carbon::now()->daysInYear
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Weather
    |--------------------------------------------------------------------------
    |
    | All weather settings.
    */
    'weather' => [
        'api_key' => env('WEATHER_API_KEY')
    ]
];
