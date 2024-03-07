<?php

namespace Database\Seeders;

use BDS\Models\Setting;
use BDS\Models\Site;
use BDS\Models\User;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Settings without site assigned to.
        Setting::create([
            'key' => 'app_login_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de connexion.',
            'text' => 'Active/Désactive le système de connexion.',
            'label_info' => 'Cocher pour activer le système de connexion au site. <br><b>Quand le système de connexion est désactivé, uniquement les personnes disposant de la permission direct <code class="text-neutral-content bg-neutral rounded-sm py-0.5 px-2">bypass login</code> pourront se connecter.</b>'
        ]);

        // Role
        Setting::create([
            'key' => 'role_manage_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de gestion des rôles.',
            'text' => 'Active/Désactive le système de gestion des rôles.',
            'label_info' => ''
        ]);
        Setting::create([
            'key' => 'role_create_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de création de rôle.',
            'text' => 'Active/Désactive le système de création de rôle.',
            'label_info' => ''
        ]);

        // Permission
        Setting::create([
            'key' => 'permission_manage_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de gestion des permissions.',
            'text' => 'Active/Désactive le système de gestion des permissions.',
            'label_info' => ''
        ]);
        Setting::create([
            'key' => 'permission_create_enabled',
            'site_id' => null,
            'value' => true,
            'label' => 'Activation du système de création de permission.',
            'text' => 'Active/Désactive le système de création de permission.',
            'label_info' => ''
        ]);

        // User Specific
        Setting::create([
            'key' => 'user_notification_email',
            'site_id' => null,
            'value' => true,
            'model_type' => User::class,
            'model_id' => 1,
            'text' => 'Active/Désactive les notifications par email.'
        ]);

        // Sites IDs
        Setting::create([
            'key' => 'site_id_selvah',
            'site_id' => null,
            'value' => 2,
            'label' => 'ID du site Selvah utilisé pour l\'affichage de certaines fonctionnalités spécifiques à Selvah.',
        ]);
        Setting::create([
            'key' => 'site_id_extrusel',
            'site_id' => null,
            'value' => 3,
            'label' => 'ID du site Extrusel utilisé pour l\'affichage de certaines fonctionnalités spécifiques à Extrusel.',
        ]);
        Setting::create([
            'key' => 'site_id_moulin_jannet',
            'site_id' => null,
            'value' => 4,
            'label' => 'ID du site Moulin Jannet utilisé pour l\'affichage de certaines fonctionnalités spécifiques à Moulin Jannet.',
        ]);
        Setting::create([
            'key' => 'site_id_val_union',
            'site_id' => null,
            'value' => 51,
            'label' => 'ID du site Val Union utilisé pour l\'affichage de certaines fonctionnalités spécifiques à Val Union.',
        ]);
        Setting::create([
            'key' => 'site_id_verdun_siege',
            'site_id' => null,
            'value' => 1,
            'label' => 'ID du site Verdun Siège utilisé pour l\'affichage de certaines fonctionnalités spécifiques à Verdun Siège.',
        ]);
        Setting::create([
            'key' => 'site_id_maintenance_bds',
            'site_id' => null,
            'value' => 5,
            'label' => 'ID du site Maintenance BDS utilisé pour l\'affichage de certaines fonctionnalités spécifiques à la Maintenance BDS.',
        ]);

        // Settings for all sites.
        for ($a = 1; $a < 52; $a++) {
            // User
            Setting::create([
                'key' => 'user_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des utilisateurs.',
                'text' => 'Active/Désactive le système de gestion des utilisateurs.'
            ]);
            Setting::create([
                'key' => 'user_create_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de création d\'utilisateur.',
                'text' => 'Active/Désactive le système de création d\'utilisateur.'
            ]);

            // Part
            Setting::create([
                'key' => 'part_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des pièces détachées.',
                'text' => 'Active/Désactive le système de gestion des pièces détachées.'
            ]);
            Setting::create([
                'key' => 'part_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de pièce détachée.',
                'text' => 'Active/Désactive le système de création de pièce détachée.'
            ]);

            // Part Entries
            Setting::create([
                'key' => 'part_entry_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création des entrées de pièce détachée.',
                'text' => 'Active/Désactive le système de création d\'entrée de pièce détachée.'
            ]);

            // Part Exits
            Setting::create([
                'key' => 'part_exit_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création des sorties de pièce détachée.',
                'text' => 'Active/Désactive le système de création de sortie de pièce détachée.'
            ]);

            // Supplier
            Setting::create([
                'key' => 'supplier_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des fournisseurs.',
                'text' => 'Active/Désactive le système de gestion des fournisseurs.'
            ]);
            Setting::create([
                'key' => 'supplier_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création des fournisseurs.',
                'text' => 'Active/Désactive le système de création des fournisseurs.'
            ]);

            // Company
            Setting::create([
                'key' => 'company_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des entreprises.',
                'text' => 'Active/Désactive le système de gestion des entreprises.'
            ]);
            Setting::create([
                'key' => 'company_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création des entreprises.',
                'text' => 'Active/Désactive le système de création des entreprises.'
            ]);

            // Zone
            Setting::create([
                'key' => 'zone_manage_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de gestion des zones.',
                'text' => 'Active/Désactive le système de gestion des zones.'
            ]);
            Setting::create([
                'key' => 'zone_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de zone.',
                'text' => 'Active/Désactive le système de création de zone.'
            ]);

            // Material
            Setting::create([
                'key' => 'material_manage_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de gestion des matériels.',
                'text' => 'Active/Désactive le système de gestion des matériels.'
            ]);
            Setting::create([
                'key' => 'material_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de matériel.',
                'text' => 'Active/Désactive le système de création de matériel.'
            ]);

            // Incident
            Setting::create([
                'key' => 'incident_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des incidents.',
                'text' => 'Active/Désactive le système de gestion des incidents.'
            ]);
            Setting::create([
                'key' => 'incident_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création d\'incident.',
                'text' => 'Active/Désactive le système de création d\'incident.'
            ]);

            // Maintenance
            Setting::create([
                'key' => 'maintenance_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des maintenances.',
                'text' => 'Active/Désactive le système de gestion des maintenances.'
            ]);
            Setting::create([
                'key' => 'maintenance_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de maintenance.',
                'text' => 'Active/Désactive le système de création de maintenance.'
            ]);

            // Cleaning
            Setting::create([
                'key' => 'cleaning_manage_enabled',
                'site_id' => $a,
                'value' => true,
                'label' => 'Activation du système de gestion des nettoyages.',
                'text' => 'Active/Désactive le système de gestion des nettoyages.'
            ]);
            Setting::create([
                'key' => 'cleaning_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de nettoyage.',
                'text' => 'Active/Désactive le système de création de nettoyage.'
            ]);

            // Calendars
            Setting::create([
                'key' => 'calendar_manage_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de gestion des calendriers.',
                'text' => 'Active/Désactive le système de gestion des calendriers.'
            ]);
            Setting::create([
                'key' => 'calendar_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création de calendrier.',
                'text' => 'Active/Désactive le système de création de calendrier.'
            ]);

            // CalendarEvents
            Setting::create([
                'key' => 'calendar_event_manage_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de gestion des évènements de calendrier.',
                'text' => 'Active/Désactive le système de gestion des évènements de calendrier.'
            ]);
            Setting::create([
                'key' => 'calendar_event_create_enabled',
                'site_id' => $a,
                'value' => $a == 1 ? false : true,
                'label' => 'Activation du système de création d\'évènement de calendrier.',
                'text' => 'Active/Désactive le système de création d\'évènement de calendrier.'
            ]);
        }

        // Settings for all sites except Verdun Siège.
        for ($i = 2; $i < 52; $i++) {

        }

        // Setting for Selvah
        $selvah = Site::where('name', 'Selvah')->first();
        Setting::create([
            'key' => 'production_objective_delivered',
            'site_id' => $selvah->id,
            'value' => 310270,
            'text' => 'Quantité de la production livré.',
            'label' => 'Quantité de la production livré.'
        ]);
        Setting::create([
            'key' => 'production_objective_todo',
            'site_id' => $selvah->id,
            'value' => 715520,
            'text' => 'Quantité de production à faire.',
            'label' => 'Quantité de production à faire.'
        ]);

        // Settings for Verdun Siège
        $verdun = Site::where('name', 'Verdun Siège')->first();
        // Site
        Setting::create([
            'key' => 'site_manage_enabled',
            'site_id' => $verdun->id,
            'value' => true,
            'label' => 'Activation du système de gestion des sites.',
            'text' => 'Active/Désactive le système de gestion des sites.',
            'label_info' => ''
        ]);
        Setting::create([
            'key' => 'site_create_enabled',
            'site_id' => $verdun->id,
            'value' => true,
            'label' => 'Activation du système de création de site.',
            'text' => 'Active/Désactive le système de création de site.',
            'label_info' => ''
        ]);

    }
}
