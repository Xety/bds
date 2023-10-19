<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BDS\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    protected array $directeurGeneralPermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'create zone',
        'update zone',

        // Material
        'viewAny material',
        'view material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
    ];

    protected array $responsablePermissions = [
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

    protected array $responsableMaintenancePermissions = [
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
        'scan-qrcode material'
    ];

    protected array $operateurSelvahPermissions = [
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
    ];

    protected array $operateurExtruselPermissions = [
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
    ];

    protected array $operateurMaintenancePermissions = [
        // Zone
        'viewAny zone',
        'view zone',

        // Material
        'viewAny material',
        'view material',
        'scan-qrcode material',
    ];

    protected array $responsableQualite = [
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
    ];

    protected array $assistanteQualiteFiliale = [
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
    ];

    protected array $assistanteQualiteBourgogneduSud = [
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
            'search role',

            // Permission
            'viewAny permission',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'search permission',

            // User
            'viewAny user',
            'view user',
            'create user',
            'update user',
            'delete user',
            'restore user',
            'search user',
            'assign-direct-permission user',

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

        // Directeur Général
        $role = Role::findByName('Directeur Général');
        $role->syncPermissions($this-> directeurGeneralPermissions);

        // Directeur Général Adjoint
        $role = Role::findByName('Directeur Général Adjoint');
        $role->syncPermissions($this-> directeurGeneralPermissions);

        // Responsable Selvah
        $role = Role::where('name', 'Responsable Selvah')->first();
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Selvah Adjoint
        $role = Role::where('name', 'Responsable Adjoint Selvah')->first();
        $role->syncPermissions($this->responsablePermissions);

        // Opérateur Selvah
        $role = Role::where('name', 'Opérateur Selvah')->first();
        $role->syncPermissions($this->operateurSelvahPermissions);

        // Responsable Extrusel
        $role = Role::where('name', 'Responsable Extrusel')->first();
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Extrusel Adjoint
        $role = Role::where('name', 'Responsable Adjoint Extrusel')->first();
        $role->syncPermissions($this->responsablePermissions);

        // Opérateur Extrusel
        $role = Role::where('name', 'Opérateur Extrusel')->first();
        $role->syncPermissions($this->operateurExtruselPermissions);

        // Responsable Silo
        $role = Role::findByName('Responsable Silo');
        $role->syncPermissions($this->responsablePermissions);

        // Responsable Qualité
        $role = Role::findByName('Responsable Qualité');
        $role->syncPermissions($this->responsableQualite);

        // Assistant(e) Qualité Filiale
        $role = Role::findByName('Assistant(e) Qualité Filiale');
        $role->syncPermissions($this->assistanteQualiteFiliale);

        // Assistant(e) Qualité Bourgogne du Sud
        $role = Role::findByName('Assistant(e) Qualité Bourgogne du Sud');
        $role->syncPermissions($this->assistanteQualiteBourgogneduSud);

        // Saisonnier Bourgogne du Sud
        $role = Role::findByName('Saisonnier Bourgogne du Sud');
        $role->syncPermissions([
            // Cleaning
            'viewAny cleaning',
            'create cleaning',
        ]);

        // Responsable Maintenance
        $role = Role::findByName('Responsable Maintenance');
        $role->syncPermissions($this->responsableMaintenancePermissions);

        // Opérateur Maintenance
        $role = Role::findByName('Opérateur Maintenance');
        $role->syncPermissions($this->operateurMaintenancePermissions);
    }
}
