<?php

namespace Database\Seeders;

use BDS\Models\User;
use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'e.fevre@bds.coop')->first();
        $user->assignRolesToSites('Administrateur', [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
            26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50
        ]);
        $user->assignRolesToSites('Responsable Selvah Adjoint', 2);

        $user = User::where('email', 'f.lequeu@bds.coop')->first();
        $user->assignRolesToSites('Responsable Selvah', 2);
        $user->assignRolesToSites('Responsable Extrusel', 3);

        $user = User::where('email', 'a.moindrot@bds.coop')->first();
        $user->assignRolesToSites('Opérateur', 2);

        $user = User::where('email', 'jm.briset@bds.coop')->first();
        $user->assignRolesToSites('Opérateur', 2);

        $user = User::where('email', 'a.bert@bds.coop')->first();
        $user->assignRolesToSites('Opérateur', 2);

        $user = User::where('email', 'c.brocot@bds.coop')->first();
        $user->assignRolesToSites('Assistant(e) Qualité', [2, 3]);

        $user = User::where('email', 'c.gateau@bds.coop')->first();
        $user->assignRolesToSites('Responsable Beaune', 6);
        $user->assignRolesToSites('Responsable Bligny sur Ouche', 7);
        $user->assignRolesToSites('Responsable Gergy', 21);
        $user->assignRolesToSites('Responsable Meursanges', 30);

        $user = User::where('email', 'f.rossignol@bds.coop')->first();
        $user->assignRolesToSites('Responsable Chalon Nord', 11);
        $user->assignRolesToSites('Responsable Crissey', 15);
    }
}
