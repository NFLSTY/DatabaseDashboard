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

        // Create 10,000 OLD random products
        for ($i = 0; $i < 10000; $i++) {
            $productName = $faker->words(3, true);
            $product = Product::create([
                'store_id' => $stores->random()->id,
                'category_id' => $categories->random()->id,
                'name' => ucfirst($productName),
                'slug' => Str::slug($productName),
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10000, 1000000),
                'quantity' => $faker->numberBetween(0, 100),
                'created_at' => now()->subDay(), // Set timestamp to yesterday
                'updated_at' => now()->subDay(),
            ]);

            if ($tags->isNotEmpty()) {
                $product->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            }
        }

        // Create 20 realistic products
        $realisticProducts = [
            ['name' => 'Kemeja Batik Pria Lengan Panjang', 'category' => 'Men\'s Fashion', 'price' => 250000],
            ['name' => 'Samsung Galaxy S25 Smartphone', 'category' => 'Phones & Tablets', 'price' => 15000000],
            ['name' => 'Blender Philips 2 Liter', 'category' => 'Home & Living', 'price' => 650000],
            ['name' => 'Sepatu Lari Adidas Ultraboost', 'category' => 'Sports & Outdoors', 'price' => 2800000],
            ['name' => 'Novel "Laskar Pelangi" by Andrea Hirata', 'category' => 'Books & Stationery', 'price' => 85000],
            ['name' => 'Tas Ransel Laptop Eiger', 'category' => 'Computers & Accessories', 'price' => 450000],
            ['name' => 'Mainan Edukasi Anak Balok Susun', 'category' => 'Toys & Hobbies', 'price' => 120000],
            ['name' => 'Kopi Arabika Gayo 250g', 'category' => 'Food & Beverage', 'price' => 75000],
            ['name' => 'Gamis Wanita Modern Bahan Katun', 'category' => 'Muslim Fashion', 'price' => 350000],
            ['name' => 'Headset Gaming Razer Blackshark V2', 'category' => 'Electronics', 'price' => 1500000],
            ['name' => 'Popok Bayi Merries Ukuran L', 'category' => 'Mother & Baby', 'price' => 180000],
            ['name' => 'Lampu Meja Belajar LED', 'category' => 'Furniture', 'price' => 200000],
            ['name' => 'Skincare Serum Wajah Somethinc', 'category' => 'Health & Beauty', 'price' => 150000],
            ['name' => 'Kamera Mirrorless Sony Alpha A6400', 'category' => 'Cameras & Drones', 'price' => 12500000],
            ['name' => 'Oli Mesin Mobil Shell Helix HX7', 'category' => 'Automotive', 'price' => 350000],
            ['name' => 'Makanan Kucing Kering Royal Canin 1kg', 'category' => 'Pet Supplies', 'price' => 125000],
            ['name' => 'Voucher Google Play 100.000', 'category' => 'Digital Goods', 'price' => 100000],
            ['name' => 'Tas Anyaman Rotan Bali', 'category' => 'Handicrafts', 'price' => 180000],
            ['name' => 'Celana Jeans Pria Levis 501', 'category' => 'Men\'s Fashion', 'price' => 900000],
            ['name' => 'Tunik Wanita Motif Bunga', 'category' => 'Women\'s Fashion', 'price' => 220000],
        ];

        $now = now();
        foreach ($realisticProducts as $index => $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            if (!$category) continue;

            $product = Product::create([
                'store_id' => $stores->random()->id,
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $faker->paragraph(3),
                'price' => $productData['price'],
                'quantity' => $faker->numberBetween(10, 100),
                'created_at' => $now->copy()->subSeconds($index), // Stagger to maintain order
                'updated_at' => $now->copy()->subSeconds($index),
            ]);

            if ($tags->isNotEmpty()) {
                $product->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            }
        }
    }
}