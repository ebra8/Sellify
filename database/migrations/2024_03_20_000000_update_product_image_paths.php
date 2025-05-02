<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class UpdateProductImagePaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            // Extract the filename from the current path
            $filename = basename($product->image);
            
            // Create a new path in the format: products/{category_slug}/{filename}
            $category = $product->category;
            $newPath = 'products/' . $category->slug . '/' . $filename;
            
            // Update the product's image path
            $product->image = $newPath;
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            // Extract the filename from the current path
            $filename = basename($product->image);
            
            // Revert to just the filename
            $product->image = $filename;
            $product->save();
        }
    }
} 