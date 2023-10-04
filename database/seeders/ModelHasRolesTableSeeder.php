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
        $user->assignRolesToSites('Administrateur', [1, 2, 3, 4]);

        $user = User::where('email', 'c.gateau@bds.coop')->first();
        $user->assignRolesToSites('Responsable Beaune', 2);

        $user = User::where('email', 'f.rossignol@bds.coop')->first();
        $user->assignRolesToSites('Responsable Chalon Nord', 3);
        $user->assignRolesToSites('Responsable Crissey', 4);

        $user = User::where('email', 'jm.briset@bds.coop')->first();
        $user->assignRolesToSites('Opérateur', [3, 4]);

        $user = User::where('email', 'a.moindrot@bds.coop')->first();
        $user->assignRolesToSites('Opérateur', 2);

        $user = User::where('email', 'a.bert@bds.coop')->first();
        $user->assignRolesToSites('Saisonnier', 2);

        $user = User::where('email', 'c.brocot@bds.coop')->first();
        $user->assignRolesToSites('Assistant(e) Qualité', [2, 3, 4]);
    }
}
