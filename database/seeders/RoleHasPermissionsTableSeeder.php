<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BDS\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    protected array $directeurGeneralPermissions = [
        // User
        'viewAny user',
        'view user',
        'search user',

        // Site
        'viewAny site',
        'view site',
        'export site',
        'search site',

        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
        'search cleaning',
        'generate-plan cleaning',

        // Incident
        'viewAny incident',
        'view incident',
        'export incident',
        'search incident',

        // Maintenance
        'viewAny maintenance',
        'view maintenance',
        'export maintenance',
        'search maintenance',

        // Part
        'viewAny part',
        'view part',
        'export part',
        'search part',
        'view-other-site part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'export partEntry',
        'search partEntry',
        'view-other-site partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'export partExit',
        'search partExit',
        'view-other-site partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'export supplier',
        'search supplier',

        // Company
        'viewAny company',
        'view company',
        'export company',
        'search company',

        // Calendar
        'viewAny calendar',
        'view calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'search calendar event',

    ];

    protected array $responsablePermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'create zone',
        'update zone',
        'delete zone',
        'export zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'create material',
        'update material',
        'delete material',
        'export material',
        'search material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'create cleaning',
        'update cleaning',
        'delete cleaning',
        'export cleaning',
        'generate-plan cleaning',

        // Incident
        'viewAny incident',
        'view incident',
        'create incident',
        'update incident',
        'delete incident',
        'export incident',
        'search incident',

        // Maintenance
        'viewAny maintenance',
        'view maintenance',
        'create maintenance',
        'update maintenance',
        'delete maintenance',
        'export maintenance',
        'search maintenance',

        // Part
        'viewAny part',
        'view part',
        'create part',
        'update part',
        'delete part',
        'export part',
        'search part',
        'generate-qrcode part',
        'scan-qrcode part',
        'view-other-site part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'create partEntry',
        'update partEntry',
        'delete partEntry',
        'export partEntry',
        'search partEntry',
        'view-other-site partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'create partExit',
        'update partExit',
        'delete partExit',
        'export partExit',
        'search partExit',
        'view-other-site partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'create supplier',
        'update supplier',
        'delete supplier',
        'export supplier',
        'search supplier',

        // Company
        'viewAny company',
        'view company',
        'create company',
        'update company',
        'delete company',
        'export company',
        'search company',

        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',

        // Selvah CorrespondenceSheet
        'viewAny selvah correspondence sheet',
        'view selvah correspondence sheet',
        'create selvah correspondence sheet',
        'update selvah correspondence sheet',
        'delete selvah correspondence sheet',
        'search selvah correspondence sheet',
        'export selvah correspondence sheet',
        'sign selvah correspondence sheet',
    ];

    protected array $responsableMaintenancePermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'create zone',
        'update zone',
        'delete zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'create material',
        'update material',
        'delete material',
        'search material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Part
        'viewAny part',
        'view part',
        'create part',
        'update part',
        'delete part',
        'export part',
        'search part',
        'generate-qrcode part',
        'scan-qrcode part',
        'view-other-site part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'create partEntry',
        'update partEntry',
        'delete partEntry',
        'export partEntry',
        'search partEntry',
        'view-other-site partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'create partExit',
        'update partExit',
        'delete partExit',
        'export partExit',
        'search partExit',
        'view-other-site partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'create supplier',
        'update supplier',
        'delete supplier',
        'export supplier',
        'search supplier',

        // Company
        'viewAny company',
        'view company',
        'create company',
        'update company',
        'delete company',
        'export company',
        'search company',

        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',
    ];

    protected array $operateurSelvahPermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'create cleaning',
        'update cleaning',

        // Incident
        'viewAny incident',
        'view incident',
        'create incident',
        'update incident',
        'search incident',

        // Maintenance
        'viewAny maintenance',
        'view maintenance',
        'create maintenance',
        'update maintenance',
        'search maintenance',

        // Company
        'viewAny company',
        'view company',
        'search company',

        // Part
        'viewAny part',
        'view part',
        'search part',
        'scan-qrcode part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'search partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'create partExit',
        'search partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'search supplier',

        // Calendar
        'viewAny calendar',
        'view calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'search calendar event',

        // Selvah CorrespondenceSheet
        'viewAny selvah correspondence sheet',
        'view selvah correspondence sheet',
        'create selvah correspondence sheet',
        'update selvah correspondence sheet',
        'search selvah correspondence sheet',
    ];

    protected array $operateurExtruselPermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'create cleaning',
        'update cleaning',

        // Incident
        'viewAny incident',
        'view incident',
        'create incident',
        'update incident',
        'search incident',

        // Maintenance
        'viewAny maintenance',
        'view maintenance',
        'create maintenance',
        'update maintenance',
        'search maintenance',

        // Company
        'viewAny company',
        'view company',
        'search company',

        // Part
        'viewAny part',
        'view part',
        'search part',
        'scan-qrcode part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'search partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'create partExit',
        'search partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'search supplier',

        // Calendar
        'viewAny calendar',
        'view calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'search calendar event',
    ];

    protected array $operateurMaintenancePermissions = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'export material',
        'search material',
        'scan-qrcode material',

        // Part
        'viewAny part',
        'view part',
        'search part',
        'scan-qrcode part',
        'view-other-site part',

        // PartEntry
        'viewAny partEntry',
        'view partEntry',
        'search partEntry',

        // PartExit
        'viewAny partExit',
        'view partExit',
        'create partExit',
        'search partExit',
        'view-other-site partExit',

        // Supplier
        'viewAny supplier',
        'view supplier',
        'search supplier',

        // Company
        'viewAny company',
        'view company',
        'search company',
    ];

    protected array $responsableQualite = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'generate-qrcode material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
        'create cleaning',
        'update cleaning',
        'search cleaning',
        'generate-plan cleaning',

        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',

        // Selvah CorrespondenceSheet
        'viewAny selvah correspondence sheet',
        'view selvah correspondence sheet',
        'search selvah correspondence sheet',
        'export selvah correspondence sheet',
    ];

    protected array $assistanteQualiteFiliale = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
        'create cleaning',
        'update cleaning',
        'search cleaning',
        'generate-plan cleaning',

        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',

        // Selvah CorrespondenceSheet
        'viewAny selvah correspondence sheet',
        'view selvah correspondence sheet',
        'create selvah correspondence sheet',
        'search selvah correspondence sheet',
        'export selvah correspondence sheet',
    ];

    protected array $assistanteQualiteBourgogneduSud = [
        // Zone
        'viewAny zone',
        'view zone',
        'search zone',

        // Material
        'viewAny material',
        'view material',
        'search material',
        'scan-qrcode material',

        // Cleaning
        'viewAny cleaning',
        'view cleaning',
        'export cleaning',
        'create cleaning',
        'update cleaning',
        'generate-plan cleaning',

        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',
    ];

    protected array $secretaireBourgogneduSud = [
        // Calendar
        'viewAny calendar',
        'view calendar',
        'create calendar',
        'update calendar',
        'delete calendar',

        // Calendar Event
        'viewAny calendar event',
        'view calendar event',
        'create calendar event',
        'update calendar event',
        'delete calendar event',
        'search calendar event',
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
            'assign-site user',

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
            'export site',
            'search site',

            // Zone
            'viewAny zone',
            'view zone',
            'create zone',
            'update zone',
            'delete zone',
            'export zone',
            'search zone',

            // Material
            'viewAny material',
            'view material',
            'create material',
            'update material',
            'delete material',
            'export material',
            'search material',
            'generate-qrcode material',
            'scan-qrcode material',

            // Cleaning
            'viewAny cleaning',
            'view cleaning',
            'create cleaning',
            'update cleaning',
            'delete cleaning',
            'export cleaning',
            'search cleaning',
            'generate-plan cleaning',

            // Incident
            'viewAny incident',
            'view incident',
            'create incident',
            'update incident',
            'delete incident',
            'export incident',
            'search incident',

            // Maintenance
            'viewAny maintenance',
            'view maintenance',
            'create maintenance',
            'update maintenance',
            'delete maintenance',
            'export maintenance',
            'search maintenance',

            // Part
            'viewAny part',
            'view part',
            'create part',
            'update part',
            'delete part',
            'export part',
            'search part',
            'generate-qrcode part',
            'scan-qrcode part',
            'view-other-site part',

            // PartEntry
            'viewAny partEntry',
            'view partEntry',
            'create partEntry',
            'update partEntry',
            'delete partEntry',
            'export partEntry',
            'search partEntry',
            'view-other-site partEntry',

            // PartExit
            'viewAny partExit',
            'view partExit',
            'create partExit',
            'update partExit',
            'delete partExit',
            'export partExit',
            'search partExit',
            'view-other-site partExit',

            // Supplier
            'viewAny supplier',
            'view supplier',
            'create supplier',
            'update supplier',
            'delete supplier',
            'export supplier',
            'search supplier',

            // Calendar
            'viewAny calendar',
            'view calendar',
            'create calendar',
            'update calendar',
            'delete calendar',

            // Calendar Event
            'viewAny calendar event',
            'view calendar event',
            'create calendar event',
            'update calendar event',
            'delete calendar event',
            'search calendar event',

            // Company
            'viewAny company',
            'view company',
            'create company',
            'update company',
            'delete company',
            'export company',
            'search company',

            // Activity
            'viewAny activity',
            'view activity',
            'delete activity',
            'search activity',

            // Selvah CorrespondenceSheet
            'viewAny selvah correspondence sheet',
            'view selvah correspondence sheet',
            'create selvah correspondence sheet',
            'update selvah correspondence sheet',
            'delete selvah correspondence sheet',
            'search selvah correspondence sheet',
            'export selvah correspondence sheet',
            'sign selvah correspondence sheet',
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

        // Responsable ValUnion
        $role = Role::where('name', 'Responsable ValUnion')->first();
        $role->syncPermissions($this->responsablePermissions);

        // Secrétaire
        $role = Role::where('name', 'Secrétaire')->first();
        $role->syncPermissions($this->secretaireBourgogneduSud);
    }
}
