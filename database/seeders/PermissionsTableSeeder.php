<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'viewAny role',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les rôles.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view role',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un rôle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create role',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un rôle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update role',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un rôle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un rôle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny permission',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les permissions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view permission',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir une permission.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create permission',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer une permission.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update permission',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour une permission.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete permission',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer une permission.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les utilisateurs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un utilisateur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un utilisateur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un utilisateur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un utilisateur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'restore user',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut restaurer un utilisateur supprimé.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les matériels.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un matériel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'export material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut exporter des matériels.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un matériel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un matériel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un matériel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'generateQrCode material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut générer des QRCode pour les matériels.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'scanQrCode material',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut scanner des QRCode pour les matériels.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny setting',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les paramètres.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view setting',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un paramètre.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create setting',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un paramètre.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update setting',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un paramètre.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete setting',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un paramètre.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les zones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir une zone.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'export zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut exporter des zones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer une zone.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour une zone.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete zone',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer une zone.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les nettoyages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un nettoyage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'export cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut exporter les nettoyages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un nettoyage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un nettoyage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete cleaning',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un nettoyage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'viewAny site',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir les nettoyages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view site',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut voir un site.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create site',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut créer un site.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update site',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut mettre à jour un site.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete site',
                'guard_name' => 'web',
                'description' => 'L\'utilisateur peut supprimer un site.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
