<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrateur',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Responsable Beaune',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Responsable Crissey',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Responsable Chalon Nord',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Assistant(e) Qualité',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Opérateur',
            'site_id' => null
        ]);

        Role::create([
            'name' => 'Saisonnier',
            'site_id' => null
        ]);
    }
}
