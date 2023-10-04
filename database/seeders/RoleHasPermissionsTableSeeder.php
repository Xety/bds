<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Administrateur Role
        $role = Role::findByName('Administrateur');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
        ]);

        // Responsable Beaune Role
        $role = Role::findByName('Responsable Beaune');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
        ]);

        // Responsable Chalon Nord Role
        $role = Role::findByName('Responsable Chalon Nord');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
        ]);

        // Assistant(e) Qualité Role
        $role = Role::findByName('Assistant(e) Qualité');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
        ]);

        // Opérateur Role
        $role = Role::findByName('Opérateur');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'create cleaning',
            'update cleaning',
        ]);

        // Saisonnier Role
        $role = Role::findByName('Saisonnier');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'create cleaning',
        ]);
    }
}
