<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'New Arrival',
            'Best Seller',
            'On Sale',
            'Clearance',
            'Featured',
            'Limited Edition',
            'Eco-Friendly',
            'Handmade',
            'Vintage',
            'Premium Quality',
            'Hot Item',
            'Staff Pick',
            'Free Shipping',
            'Pre-Order',
            'Back in Stock',
            'Exclusive',
            'Top Rated',
            'Organic',
            'Locally Sourced',
            'Recycled'
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }
    }
}
