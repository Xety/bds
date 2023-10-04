<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            array (
                'id' => 1,
                'username' => 'Emeric.F',
                'email' => 'e.fevre@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => '192.168.56.1',
                'last_login_date' => '2023-08-15 09:46:50',
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-15 09:46:50',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 2,
                'username' => 'Franck.L',
                'email' => 'f.lequeu@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => NULL,
                'last_login_date' => NULL,
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-09 22:02:33',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 3,
                'username' => 'Anthony.M',
                'email' => 'a.moindrot@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => NULL,
                'last_login_date' => NULL,
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-09 22:02:33',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 4,
                'username' => 'JeanMichel.B',
                'email' => 'jm.briset@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => NULL,
                'last_login_date' => NULL,
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-09 22:02:33',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 5,
                'username' => 'Alexis.B',
                'email' => 'a.bert@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => NULL,
                'last_login_date' => NULL,
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-09 22:02:33',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 6,
                'username' => 'Charline.B',
                'email' => 'c.brocot@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => NULL,
                'last_login_date' => NULL,
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-09 22:02:33',
                'updated_at' => '2023-08-09 22:02:33',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 7,
                'username' => 'Christophe.G',
                'email' => 'c.gateau@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => '37.166.150.14',
                'last_login_date' => '2023-08-10 14:06:12',
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-10 14:03:17',
                'updated_at' => '2023-08-10 14:06:12',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 8,
                'username' => 'Fabrice.R',
                'email' => 'f.rossignol@bds.coop',
                'password' => '$2y$10$HN7627lyelqBGAsI3ORVD.vY.NSmQtYPG3jwenOW359S9xVCFho6W',
                'remember_token' => NULL,
                'cleaning_count' => 0,
                'last_login_ip' => '37.166.150.14',
                'last_login_date' => '2023-08-10 14:06:12',
                'deleted_user_id' => NULL,
                'created_at' => '2023-08-10 14:03:17',
                'updated_at' => '2023-08-10 14:06:12',
                'deleted_at' => NULL,
            ),
        ));
    }
}
