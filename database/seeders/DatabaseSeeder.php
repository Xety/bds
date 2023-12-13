<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users & Accounts
        $this->call(UsersTableSeeder::class);

        // Sites
        $this->call(SitesTableSeeder::class);
        $this->call(SitesUsersTableSeeder::class);

        // Permissions
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);

        // Settings
        $this->call(SettingsTableSeeder::class);

        // Zones
        $this->call(ZonesTableSeeder::class);

        // Materials
        $this->call(MaterialsTableSeeder::class);

        // Cleanings
        $this->call(CleaningsTableSeeder::class);

        // Suppliers
        $this->call(SuppliersTableSeeder::class);
    }
}
