<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReplaceGearProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the electronics category ID
        $categoryId = DB::table('categories')->where('slug', 'electronics')->first()->id;

        // Delete old gear products
        DB::table('products')->whereIn('slug', ['industrial-gear-set', 'precision-gearbox'])->delete();

        // Add new gaming peripherals
        $products = [
            [
                'name' => 'ASUS ROG Strix G15',
                'description' => 'High-performance gaming laptop with RTX 4070, 32GB RAM, and 1TB SSD. Features a 165Hz display and RGB keyboard.',
                'image' => 'products/electronics/rog-strix.jpg',
                'price' => 1799.99,
                'stock' => 12,
                'is_active' => true,
                'slug' => Str::slug('ASUS ROG Strix G15'),
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Logitech G Pro X Superlight',
                'description' => 'Ultra-lightweight wireless gaming mouse with HERO 25K sensor, 5 programmable buttons, and up to 70 hours of battery life.',
                'image' => 'products/electronics/logitech-gpro.jpg',
                'price' => 149.99,
                'stock' => 25,
                'is_active' => true,
                'slug' => Str::slug('Logitech G Pro X Superlight'),
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the new products
        DB::table('products')->insert($products);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete the new products
        DB::table('products')->whereIn('slug', ['asus-rog-strix-g15', 'logitech-g-pro-x-superlight'])->delete();

        // Restore the old gear products
        $categoryId = DB::table('categories')->where('slug', 'gears')->first()->id;
        
        $products = [
            [
                'name' => 'Industrial Gear Set',
                'description' => 'High-precision industrial gear set for heavy machinery. Made from hardened steel for durability.',
                'image' => 'products/gears/gear-set.jpg',
                'price' => 299.99,
                'stock' => 15,
                'is_active' => true,
                'slug' => Str::slug('Industrial Gear Set'),
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Precision Gearbox',
                'description' => 'Professional-grade gearbox with multiple speed ratios. Perfect for industrial applications.',
                'image' => 'products/gears/gearbox.jpg',
                'price' => 499.99,
                'stock' => 8,
                'is_active' => true,
                'slug' => Str::slug('Precision Gearbox'),
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
} 