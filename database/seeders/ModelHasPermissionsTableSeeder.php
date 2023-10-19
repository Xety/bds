<?php

namespace Database\Seeders;

use BDS\Models\User;
use Illuminate\Database\Seeder;

class ModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'e.fevre@bds.coop')->first();
        $user->assignPermissionsToSites('bypass login', 0);

        $user = User::where('email', 'y.joly@bds.coop')->first();
        $user->assignPermissionsToSites('bypass login', 0);

        $user = User::where('email', 'b.combemorel@bds.coop')->first();
        $user->assignPermissionsToSites('bypass login', 0);
    }
}
