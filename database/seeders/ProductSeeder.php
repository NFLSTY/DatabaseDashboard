<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $stores = Store::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($stores->isEmpty() || $categories->isEmpty()) {
            $this->command->info('No stores or categories found, skipping product seeding.');
            return;
        }

        // Create 10000 products
        for ($i = 0; $i < 10000; $i++) {
            $productName = $faker->words(3, true);
            $product = Product::create([
                'store_id' => $stores->random()->id,
                'category_id' => $categories->random()->id,
                'name' => ucfirst($productName),
                'slug' => Str::slug($productName),
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10, 1000),
                'quantity' => $faker->numberBetween(0, 100),
            ]);

            // Attach 1 to 3 random tags to the product
            // This handles the product_tags pivot table seeding
            $product->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
