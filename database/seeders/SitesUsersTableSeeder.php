<?php

namespace Database\Seeders;

use BDS\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesUsersTableSeeder extends Seeder
{
    protected array $allSites = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
        26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51
    ];

    protected array $allSitesExceptVerdunSiege = [
        2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
        26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'e.fevre@bds.coop')->first();
        $user->sites()->sync($this->allSites);
        $user->sites()->syncWithPivotValues([2], ['manager' => true], false);

        $user = User::where('email', 'f.lequeu@bds.coop')->first();
        $user->sites()->syncWithPivotValues([2, 3], ['manager' => true]);

        $user = User::where('email', 'a.moindrot@bds.coop')->first();
        $user->sites()->sync([2]);

        $user = User::where('email', 'jm.briset@bds.coop')->first();
        $user->sites()->sync([2]);

        $user = User::where('email', 'a.bert@bds.coop')->first();
        $user->sites()->sync([2]);

        $user = User::where('email', 'c.brocot@bds.coop')->first();
        $user->sites()->sync([2, 3, 4]);

        $user = User::where('email', 'c.gateau@bds.coop')->first();
        $user->sites()->syncWithPivotValues([6, 7, 21, 30], ['manager' => true]);

        $user = User::where('email', 'f.rossignol@bds.coop')->first();
        $user->sites()->syncWithPivotValues([11, 15],  ['manager' => true]);

        $user = User::where('email', 'y.joly@bds.coop')->first();
        $user->sites()->sync($this->allSites);

        $user = User::where('email', 'b.combemorel@bds.coop')->first();
        $user->sites()->sync($this->allSites);

        $user = User::where('email', 'r.husmann@bds.coop')->first();
        $user->sites()->sync($this->allSites);

        $user = User::where('email', 'jl.fargere@bds.coop')->first();
        $user->sites()->sync($this->allSitesExceptVerdunSiege);

        $user = User::where('email', 's.seraut@bds.coop')->first();
        $user->sites()->sync($this->allSitesExceptVerdunSiege);

        $user = User::where('email', 's.nnier@bds.coop')->first();
        $user->sites()->sync([6, 7, 21, 30]);

        $user = User::where('email', 'm.allain@bds.coop')->first();
        $user->sites()->syncWithPivotValues([51], ['manager' => true]);

        $user = User::where('email', 'c.poncet@bds.coop')->first();
        $user->sites()->sync([3, 11]);
    }
}
