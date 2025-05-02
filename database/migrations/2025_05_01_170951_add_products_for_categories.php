<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AddProductsForCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get category IDs
        $categoryIds = [
            'gears' => DB::table('categories')->where('slug', 'gears')->first()->id,
            'electronics' => DB::table('categories')->where('slug', 'electronics')->first()->id,
            'books' => DB::table('categories')->where('slug', 'books')->first()->id,
            'watches' => DB::table('categories')->where('slug', 'watches')->first()->id,
            'sports-outdoors' => DB::table('categories')->where('slug', 'sports-outdoors')->first()->id,
            'home-kitchen' => DB::table('categories')->where('slug', 'home-kitchen')->first()->id,
            'clothing' => DB::table('categories')->where('slug', 'clothing')->first()->id,
        ];

        $products = [
            // Gears Products
            [
                'category_id' => $categoryIds['gears'],
                'name' => 'Industrial Gear Set',
                'description' => 'High-precision industrial gear set for heavy machinery. Made from hardened steel for durability.',
                'image' => 'products/gears/gear-set.jpg',
                'price' => 299.99,
                'stock' => 15,
                'is_active' => true,
                'slug' => Str::slug('Industrial Gear Set'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['gears'],
                'name' => 'Precision Gearbox',
                'description' => 'Professional-grade gearbox with multiple speed ratios. Perfect for industrial applications.',
                'image' => 'products/gears/gearbox.jpg',
                'price' => 499.99,
                'stock' => 8,
                'is_active' => true,
                'slug' => Str::slug('Precision Gearbox'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Electronics Products
            [
                'category_id' => $categoryIds['electronics'],
                'name' => 'Wireless Earbuds',
                'description' => 'High-quality wireless earbuds with noise cancellation and 24-hour battery life.',
                'image' => 'products/electronics/earbuds.jpg',
                'price' => 129.99,
                'stock' => 25,
                'is_active' => true,
                'slug' => Str::slug('Wireless Earbuds'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['electronics'],
                'name' => 'Smart Watch',
                'description' => 'Feature-rich smartwatch with health monitoring and GPS tracking.',
                'image' => 'products/electronics/smartwatch.jpg',
                'price' => 199.99,
                'stock' => 20,
                'is_active' => true,
                'slug' => Str::slug('Smart Watch'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Books Products
            [
                'category_id' => $categoryIds['books'],
                'name' => 'The Art of Programming',
                'description' => 'Comprehensive guide to modern programming techniques and best practices.',
                'image' => 'products/books/programming.jpg',
                'price' => 49.99,
                'stock' => 30,
                'is_active' => true,
                'slug' => Str::slug('The Art of Programming'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['books'],
                'name' => 'Business Strategy Guide',
                'description' => 'Essential guide for entrepreneurs and business leaders.',
                'image' => 'products/books/business.jpg',
                'price' => 39.99,
                'stock' => 25,
                'is_active' => true,
                'slug' => Str::slug('Business Strategy Guide'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Watches Products
            [
                'category_id' => $categoryIds['watches'],
                'name' => 'Classic Chronograph',
                'description' => 'Elegant chronograph watch with leather strap and sapphire crystal.',
                'image' => 'products/watches/chronograph.jpg',
                'price' => 299.99,
                'stock' => 12,
                'is_active' => true,
                'slug' => Str::slug('Classic Chronograph'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['watches'],
                'name' => 'Diver\'s Watch',
                'description' => 'Professional diving watch with 200m water resistance.',
                'image' => 'products/watches/diver.jpg',
                'price' => 399.99,
                'stock' => 10,
                'is_active' => true,
                'slug' => Str::slug('Divers Watch'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sports & Outdoors Products
            [
                'category_id' => $categoryIds['sports-outdoors'],
                'name' => 'Professional Yoga Mat',
                'description' => 'Extra thick yoga mat with alignment lines and carrying strap.',
                'image' => 'products/sports/yoga-mat.jpg',
                'price' => 49.99,
                'stock' => 40,
                'is_active' => true,
                'slug' => Str::slug('Professional Yoga Mat'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['sports-outdoors'],
                'name' => 'Camping Tent',
                'description' => '4-person camping tent with weather protection and easy setup.',
                'image' => 'products/sports/tent.jpg',
                'price' => 199.99,
                'stock' => 15,
                'is_active' => true,
                'slug' => Str::slug('Camping Tent'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Home & Kitchen Products
            [
                'category_id' => $categoryIds['home-kitchen'],
                'name' => 'Smart Coffee Maker',
                'description' => 'Programmable coffee maker with smartphone control and thermal carafe.',
                'image' => 'products/home/coffee-maker.jpg',
                'price' => 149.99,
                'stock' => 20,
                'is_active' => true,
                'slug' => Str::slug('Smart Coffee Maker'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['home-kitchen'],
                'name' => 'Professional Knife Set',
                'description' => 'Complete set of high-quality kitchen knives with wooden block.',
                'image' => 'products/home/knife-set.jpg',
                'price' => 199.99,
                'stock' => 15,
                'is_active' => true,
                'slug' => Str::slug('Professional Knife Set'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Clothing Products
            [
                'category_id' => $categoryIds['clothing'],
                'name' => 'Designer T-Shirt',
                'description' => 'Premium cotton t-shirt with modern design and comfortable fit.',
                'image' => 'products/clothing/tshirt.jpg',
                'price' => 29.99,
                'stock' => 50,
                'is_active' => true,
                'slug' => Str::slug('Designer T-Shirt'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $categoryIds['clothing'],
                'name' => 'Classic Denim Jacket',
                'description' => 'Vintage-style denim jacket with modern comfort features.',
                'image' => 'products/clothing/denim-jacket.jpg',
                'price' => 89.99,
                'stock' => 25,
                'is_active' => true,
                'slug' => Str::slug('Classic Denim Jacket'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the products
        DB::table('products')->insert($products);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $slugs = [
            'industrial-gear-set',
            'precision-gearbox',
            'wireless-earbuds',
            'smart-watch',
            'the-art-of-programming',
            'business-strategy-guide',
            'classic-chronograph',
            'divers-watch',
            'professional-yoga-mat',
            'camping-tent',
            'smart-coffee-maker',
            'professional-knife-set',
            'designer-t-shirt',
            'classic-denim-jacket'
        ];
        DB::table('products')->whereIn('slug', $slugs)->delete();
    }
}
