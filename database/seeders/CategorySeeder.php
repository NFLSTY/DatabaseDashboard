<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Men\'s Fashion',
            'Women\'s Fashion',
            'Phones & Tablets',
            'Computers & Accessories',
            'Health & Beauty',
            'Home & Living',
            'Mother & Baby',
            'Toys & Hobbies',
            'Sports & Outdoors',
            'Books & Stationery',
            'Food & Beverage',
            'Automotive',
            'Pet Supplies',
            'Vouchers & Tickets',
            'Furniture',
            'Cameras & Drones',
            'Digital Goods',
            'Muslim Fashion',
            'Handicrafts'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);
        }
    }
}
