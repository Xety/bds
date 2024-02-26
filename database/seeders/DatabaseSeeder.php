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
        $this->call(MaterialsUsersTableSeeder::class);

        // Cleanings
        $this->call(CleaningsTableSeeder::class);

        // Suppliers
        $this->call(SuppliersTableSeeder::class);

        // Parts
        $this->call(PartsTableSeeder::class);
        $this->call(MaterialsPartsTableSeeder::class);
        $this->call(PartEntriesTableSeeder::class);
        $this->call(PartExitsTableSeeder::class);
        $this->call(PartsUsersTableSeeder::class);

        // Companies
        $this->call(CompaniesTableSeeder::class);

        // Maintenances
        $this->call(MaintenancesTableSeeder::class);
        $this->call(CompanyMaintenanceTableSeeder::class);
        $this->call(MaintenanceUserTableSeeder::class);

        // Incidents
        $this->call(IncidentsTableSeeder::class);

        // Calendars
        $this->call(CalendarEventsTableSeeder::class);
    }
}
