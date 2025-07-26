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
        // Order is important
        $this->call([
            UserSeeder::class,
            StoreSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
