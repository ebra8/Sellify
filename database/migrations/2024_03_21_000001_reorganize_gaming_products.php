<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReorganizeGamingProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get category IDs
        $laptopsId = DB::table('categories')->where('slug', 'laptops')->first()->id;
        $gearsId = DB::table('categories')->where('slug', 'gears')->first()->id;

        // Move ROG Strix G15 to laptops category
        DB::table('products')
            ->where('slug', 'asus-rog-strix-g15')
            ->update([
                'category_id' => $laptopsId,
                'image' => 'products/laptops/rog-strix.jpg'
            ]);

        // Move Logitech G Pro X to gears category
        DB::table('products')
            ->where('slug', 'logitech-g-pro-x-superlight')
            ->update([
                'category_id' => $gearsId,
                'image' => 'products/gears/logitech-gpro.jpg'
            ]);

        // Add new ROG Strix Scope RX keyboard
        DB::table('products')->insert([
            'name' => 'ROG Strix Scope RX',
            'description' => 'Premium mechanical gaming keyboard with IP57 waterproof & dust resistance, ROG RX optical mechanical switches, and customizable per-key RGB lighting.',
            'image' => 'products/gears/ROG-Strix.png',
            'price' => 169.99,
            'stock' => 20,
            'is_active' => true,
            'slug' => Str::slug('ROG Strix Scope RX'),
            'category_id' => $gearsId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Get electronics category ID
        $electronicsId = DB::table('categories')->where('slug', 'electronics')->first()->id;

        // Move ROG Strix G15 back to electronics category
        DB::table('products')
            ->where('slug', 'asus-rog-strix-g15')
            ->update([
                'category_id' => $electronicsId,
                'image' => 'products/electronics/rog-strix.jpg'
            ]);

        // Move Logitech G Pro X back to electronics category
        DB::table('products')
            ->where('slug', 'logitech-g-pro-x-superlight')
            ->update([
                'category_id' => $electronicsId,
                'image' => 'products/electronics/logitech-gpro.jpg'
            ]);

        // Delete the ROG Strix Scope RX keyboard
        DB::table('products')
            ->where('slug', 'rog-strix-scope-rx')
            ->delete();
    }
} 