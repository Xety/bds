<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $accounts = [
            [
                'user_id' => 1,
                'first_name' => 'Emeric',
                'last_name' => 'Fevre',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 2,
                'first_name' => 'Franck',
                'last_name' => 'Lequeu',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 3,
                'first_name' => 'Anthony',
                'last_name' => 'Moindrot',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 4,
                'first_name' => 'JeanMichel',
                'last_name' => 'Briset',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 5,
                'first_name' => 'Alexis',
                'last_name' => 'Bert',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 6,
                'first_name' => 'Charline',
                'last_name' => 'Brocot',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 7,
                'first_name' => 'Christophe',
                'last_name' => 'Gateau',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 8,
                'first_name' => 'Fabrice',
                'last_name' => 'Rossignol',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('accounts')->insert($accounts);
    }
}
