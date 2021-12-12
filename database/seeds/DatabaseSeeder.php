<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             JobSeeder::class,
             UserSeeder::class,
             PermissionSeeder::class,
             CategorySeeder::class,
             UnitSeeder::class,
             SupplierSeeder::class,
             ProductSeeder::class,
             StockSeeder::class,
             SettingsSeeder::class,
         ]);

    }
}
