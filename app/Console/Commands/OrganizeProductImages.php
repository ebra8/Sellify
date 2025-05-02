<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class OrganizeProductImages extends Command
{
    protected $signature = 'products:organize-images';
    protected $description = 'Organize product images into category-based directories';

    public function handle()
    {
        // Create the base products directory if it doesn't exist
        $baseDir = storage_path('app/public/products');
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Get all products
        $products = Product::with('category')->get();

        foreach ($products as $product) {
            // Create category directory if it doesn't exist
            $categoryDir = $baseDir . '/' . $product->category->slug;
            if (!file_exists($categoryDir)) {
                mkdir($categoryDir, 0755, true);
            }

            // Get the current image path
            $currentImage = $product->image;
            
            // If the image is already in the correct location, skip it
            if (strpos($currentImage, 'products/' . $product->category->slug . '/') === 0) {
                $this->info("Image already in correct location: {$currentImage}");
                continue;
            }

            // Get the filename from the current path
            $filename = basename($currentImage);
            
            // Define the new path
            $newPath = 'products/' . $product->category->slug . '/' . $filename;
            
            // Check if the image exists in the old location
            $oldPath = public_path('images/products/' . $filename);
            if (file_exists($oldPath)) {
                // Copy the image to the new location
                copy($oldPath, storage_path('app/public/' . $newPath));
                $this->info("Copied image: {$filename} to {$newPath}");
                
                // Update the product's image path
                $product->image = $newPath;
                $product->save();
                $this->info("Updated product {$product->name} with new image path: {$newPath}");
            } else {
                $this->warn("Warning: Image not found at {$oldPath}");
            }
        }

        $this->info('Image organization complete!');
    }
} 