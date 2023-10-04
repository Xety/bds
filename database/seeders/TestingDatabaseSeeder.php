<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DatabaseSeeder
        $this->call(DatabaseSeeder::class);
    }
}
