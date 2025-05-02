<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class UpdateProductImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $imageMap = [
            'coffee-maker.jpg' => 'product1.jpg',
            'shirt.jpg' => 'product2.jpg',
            'programming-book.jpg' => 'product3.jpg',
            'yoga-mat.jpg' => 'product4.jpg',
            'smartphone.jpg' => 'product5.jpg',
            'headphones.jpg' => 'product6.jpg',
            'cookware.jpg' => 'product7.jpg',
            'novel.jpg' => 'product8.jpg',
        ];

        foreach ($imageMap as $oldImage => $newImage) {
            Product::where('image', $oldImage)->update(['image' => $newImage]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $imageMap = [
            'product1.jpg' => 'coffee-maker.jpg',
            'product2.jpg' => 'shirt.jpg',
            'product3.jpg' => 'programming-book.jpg',
            'product4.jpg' => 'yoga-mat.jpg',
            'product5.jpg' => 'smartphone.jpg',
            'product6.jpg' => 'headphones.jpg',
            'product7.jpg' => 'cookware.jpg',
            'product8.jpg' => 'novel.jpg',
        ];

        foreach ($imageMap as $oldImage => $newImage) {
            Product::where('image', $oldImage)->update(['image' => $newImage]);
        }
    }
} 