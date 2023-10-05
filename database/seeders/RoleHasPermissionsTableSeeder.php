<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    protected $responsablePermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'create zone',
        'update zone',
        'delete zone',

        // Material
        'viewAny material',
        'view material',
        'create material',
        'update material',
        'delete material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
        'create cleaning',
        'update cleaning',
        'delete cleaning',
    ];

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Administrateur Role
        $role = Role::findByName('Développeur');
        $role->syncPermissions([
            // Role
            'viewAny role',
            'view role',
            'create role',
            'update role',
            'delete role',

            // Permission
            'viewAny permission',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',

            // User
            'viewAny user',
            'view user',
            'create user',
            'update user',
            'delete user',
            'restore user',

            // Setting
            'viewAny setting',
            'view setting',
            'create setting',
            'update setting',
            'delete setting',

            // Site
            'viewAny site',
            'view site',
            'create site',
            'update site',
            'delete site',

            // Zone
            'viewAny zone',
            'view zone',
            'create zone',
            'update zone',
            'delete zone',

            // Material
            'viewAny material',
            'view material',
            'create material',
            'update material',
            'delete material',
            'generate-qrcode material',
            'scan-qrcode material',

            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
        ]);

        // Responsable Selvah
        $role = Role::findByName('Responsable Selvah');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Selvah Adjoint
        $role = Role::findByName('Responsable Selvah Adjoint');
        $role->syncPermissions($this->responsablePermissions);

        // Assistant(e) Qualité
        $role = Role::findByName('Assistant(e) Qualité');
        $role->syncPermissions([
            // Zone
            'viewAny zone',
            'view zone',

            // Material
            'viewAny material',
            'view material',
            'scan-qrcode material',

            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'export cleaning',
            'create cleaning',
            'update cleaning',
        ]);

        // Opérateur
        $role = Role::findByName('Opérateur');
        $role->syncPermissions([
            // Zone
            'viewAny zone',
            'view zone',

            // Material
            'viewAny material',
            'view material',
            'scan-qrcode material',

            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'create cleaning',
            'update cleaning',
        ]);

        // Saisonnier
        $role = Role::findByName('Saisonnier');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'create cleaning',
        ]);

        // Responsable Extrusel
        $role = Role::findByName('Responsable Extrusel');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Extrusel Adjoint
        $role = Role::findByName('Responsable Extrusel Adjoint');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Beaune
        $role = Role::findByName('Responsable Beaune');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Bligny sur Ouche
        $role = Role::findByName('Responsable Bligny sur Ouche');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Gergy
        $role = Role::findByName('Responsable Gergy');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Meursanges
        $role = Role::findByName('Responsable Meursanges');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Chalon Nord
        $role = Role::findByName('Responsable Chalon Nord');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Crissey
        $role = Role::findByName('Responsable Crissey');
        $role->syncPermissions($this->responsablePermissions);
    }
}
