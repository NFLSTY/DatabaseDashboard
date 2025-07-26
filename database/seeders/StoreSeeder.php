<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Faker\Factory as Faker;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        // Create a store for each user
        foreach ($users as $user) {
            Store::create([
                'user_id' => $user->id,
                'name' => $faker->unique()->company,
                'description' => $faker->paragraph,
                'is_active' => $faker->boolean(90), // 90% chance of being active
            ]);
        }
    }
}
