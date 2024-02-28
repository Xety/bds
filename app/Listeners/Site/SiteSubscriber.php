<?php

namespace BDS\Listeners\Site;

use BDS\Events\Site\CreatedEvent;
use BDS\Models\Setting;
use BDS\Models\User;
use Illuminate\Events\Dispatcher;

class SiteSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return array
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            CreatedEvent::class => 'handleCreated'
        ];
    }

    /**
     * Handle site created events.
     *
     * @param CreatedEvent $event
     *
     * @return bool
     */
    public function handleCreated(CreatedEvent $event): bool
    {
        Setting::insert([
            // Users
            [
                'key' => 'user_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des utilisateurs.',
                'text' => 'Active/Désactive le système de gestion des utilisateurs.'
            ],
            [
                'key' => 'user_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création d\'utilisateur.',
                'text' => 'Active/Désactive le système de création d\'utilisateur.'
            ],

            // Part
            [
                'key' => 'part_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des pièces détachées.',
                'text' => 'Active/Désactive le système de gestion des pièces détachées.'
            ],
            [
                'key' => 'part_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de pièce détachée.',
                'text' => 'Active/Désactive le système de création de pièce détachée.'
            ],

            // Part Entries
            [
                'key' => 'part_entry_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création des entrées de pièce détachée.',
                'text' => 'Active/Désactive le système de création d\'entrée de pièce détachée.'
            ],

            // Part Exits
            [
                'key' => 'part_exit_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création des sorties de pièce détachée.',
                'text' => 'Active/Désactive le système de création de sortie de pièce détachée.'
            ],

            // Part Supplier
            [
                'key' => 'supplier_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des fournisseurs.',
                'text' => 'Active/Désactive le système de gestion des fournisseurs.'
            ],
            [
                'key' => 'supplier_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création des fournisseurs.',
                'text' => 'Active/Désactive le système de création des fournisseurs.'
            ],

            // Zone
            [
                'key' => 'zone_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des zones.',
                'text' => 'Active/Désactive le système de gestion des zones.'
            ],
            [
                'key' => 'zone_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de zone.',
                'text' => 'Active/Désactive le système de création de zone.'
            ],

            // Material
            [
                'key' => 'material_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des matériels.',
                'text' => 'Active/Désactive le système de gestion des matériels.'
            ],
            [
                'key' => 'material_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de matériel.',
                'text' => 'Active/Désactive le système de création de matériel.'
            ],

            // Incident
            [
                'key' => 'incident_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des incidents.',
                'text' => 'Active/Désactive le système de gestion des incidents.'
            ],
            [
                'key' => 'incident_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création d\'incident.',
                'text' => 'Active/Désactive le système de création d\'incident.'
            ],

            // Maintenance
            [
                'key' => 'maintenance_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des maintenances.',
                'text' => 'Active/Désactive le système de gestion des maintenances.'
            ],
            [
                'key' => 'maintenance_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de maintenance.',
                'text' => 'Active/Désactive le système de création de maintenance.'
            ],

            // Cleaning
            [
                'key' => 'cleaning_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des nettoyages.',
                'text' => 'Active/Désactive le système de gestion des nettoyages.'
            ],
            [
                'key' => 'cleaning_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de nettoyage.',
                'text' => 'Active/Désactive le système de création de nettoyage.'
            ],

            // Company
            [
                'key' => 'company_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des entreprises.',
                'text' => 'Active/Désactive le système de gestion des entreprises.'
            ],
            [
                'key' => 'company_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création des entreprises.',
                'text' => 'Active/Désactive le système de création des entreprises.'
            ],

            // Calendar
            [
                'key' => 'calendar_manage_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de gestion des calendriers.',
                'text' => 'Active/Désactive le système de gestion des calendriers.'
            ],
            [
                'key' => 'calendar_create_enabled',
                'site_id' => $event->site->id,
                'value' => serialize(true),
                'label' => 'Activation du système de création de calendrier.',
                'text' => 'Active/Désactive le système de création de calendrier.'
            ],
        ]);

        $user = User::where('email', 'e.fevre@bds.coop')->first();
        $user->sites()->syncWithoutDetaching([$event->site->id]);
        $user->assignRolesToSites('Développeur', $event->site->id);

        $user = User::where('email', 'y.joly@bds.coop')->first();
        $user->sites()->syncWithoutDetaching([$event->site->id]);
        $user->assignRolesToSites('Directeur Général Adjoint', $event->site->id);

        $user = User::where('email', 'b.combemorel@bds.coop')->first();
        $user->sites()->syncWithoutDetaching([$event->site->id]);
        $user->assignRolesToSites('Directeur Général', $event->site->id);

        return true;
    }
}
