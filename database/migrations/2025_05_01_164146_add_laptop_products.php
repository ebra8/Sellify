<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AddLaptopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the laptops category ID
        $categoryId = DB::table('categories')->where('slug', 'laptops')->first()->id;

        $products = [
            [
                'name' => 'MSI Gaming Laptop',
                'description' => 'Powerful gaming laptop with RTX 4070, 32GB RAM, and 1TB SSD. Perfect for gaming and content creation.',
                'image' => 'products/laptops/msi.png',
                'price' => 1499.99,
                'stock' => 10,
                'is_active' => true,
                'slug' => Str::slug('MSI Gaming Laptop'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Premium business laptop with Intel Core i7, 16GB RAM, and 512GB SSD. Perfect for professionals.',
                'image' => 'products/laptops/lenovo.png',
                'price' => 1299.99,
                'stock' => 15,
                'is_active' => true,
                'slug' => Str::slug('Lenovo ThinkPad X1'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Ultra-slim laptop with 4K display, Intel Core i9, 32GB RAM, and 1TB SSD. Perfect for creative professionals.',
                'image' => 'products/laptops/default-product.jpg',
                'price' => 1999.99,
                'stock' => 8,
                'is_active' => true,
                'slug' => Str::slug('Dell XPS 15'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Add category_id to each product
        foreach ($products as &$product) {
            $product['category_id'] = $categoryId;
        }

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
        $slugs = ['msi-gaming-laptop', 'lenovo-thinkpad-x1', 'dell-xps-15'];
        DB::table('products')->whereIn('slug', $slugs)->delete();
    }
}
