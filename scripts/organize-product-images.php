<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/app.php';

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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
        echo "Image already in correct location: {$currentImage}\n";
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
        echo "Copied image: {$filename} to {$newPath}\n";
        
        // Update the product's image path
        $product->image = $newPath;
        $product->save();
        echo "Updated product {$product->name} with new image path: {$newPath}\n";
    } else {
        echo "Warning: Image not found at {$oldPath}\n";
    }
}

echo "Image organization complete!\n"; 