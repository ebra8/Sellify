<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AddMoreCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => 'Gears',
                'description' => 'High-quality gears and mechanical parts for various applications',
                'image' => 'gears.jpg',
                'slug' => Str::slug('Gears'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Electronics',
                'description' => 'Latest electronic gadgets and devices for everyday use',
                'image' => 'electronics.jpg',
                'slug' => Str::slug('Electronics'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'description' => 'Wide selection of books across various genres and topics',
                'image' => 'books.jpg',
                'slug' => Str::slug('Books'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Watches',
                'description' => 'Elegant timepieces from classic to modern designs',
                'image' => 'watches.jpg',
                'slug' => Str::slug('Watches'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Equipment and gear for sports and outdoor activities',
                'image' => 'sports_&_outdoors.jpg',
                'slug' => Str::slug('Sports & Outdoors'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Everything you need for your home and kitchen',
                'image' => 'home_&_kitchen.jpg',
                'slug' => Str::slug('Home & Kitchen'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashionable clothing for all seasons and occasions',
                'image' => 'clothing.jpg',
                'slug' => Str::slug('Clothing'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert the categories
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $slugs = [
            'gears',
            'electronics',
            'books',
            'watches',
            'sports-outdoors',
            'home-kitchen',
            'clothing'
        ];
        DB::table('categories')->whereIn('slug', $slugs)->delete();
    }
}
