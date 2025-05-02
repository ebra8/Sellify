<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DownloadMissingImages extends Command
{
    protected $signature = 'products:download-missing-images';
    protected $description = 'Download missing product images';

    public function handle()
    {
        // Define missing image URLs
        $missingImages = [
            'home-kitchen' => [
                'coffee-maker.jpg' => 'https://images.unsplash.com/photo-1570486916331-9d0a0d8a0c8a?w=800&q=80',
            ],
            'gears' => [
                'gear-set.jpg' => 'https://images.unsplash.com/photo-1581092921461-39b9d08a9b21?w=800&q=80',
                'gearbox.jpg' => 'https://images.unsplash.com/photo-1581092921461-39b9d08a9b21?w=800&q=80',
            ],
        ];

        // Create base directory if it doesn't exist
        $baseDir = storage_path('app/public/products');
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Download missing images
        foreach ($missingImages as $category => $images) {
            // Create category directory
            $categoryDir = $baseDir . '/' . $category;
            if (!file_exists($categoryDir)) {
                mkdir($categoryDir, 0755, true);
            }

            // Download each image
            foreach ($images as $filename => $url) {
                $filePath = $categoryDir . '/' . $filename;
                
                // Skip if file already exists
                if (file_exists($filePath)) {
                    $this->info("File already exists: {$category}/{$filename}");
                    continue;
                }

                // Download the image
                $imageContent = @file_get_contents($url);
                if ($imageContent !== false) {
                    file_put_contents($filePath, $imageContent);
                    $this->info("Downloaded: {$category}/{$filename}");
                } else {
                    $this->error("Failed to download: {$category}/{$filename}");
                }
            }
        }

        // Update product image paths in database
        $products = Product::with('category')->get();
        foreach ($products as $product) {
            $category = $product->category;
            $filename = basename($product->image);
            
            // Special cases for products with missing images
            switch ($product->slug) {
                case 'industrial-gear-set':
                    $filename = 'gear-set.jpg';
                    break;
                case 'precision-gearbox':
                    $filename = 'gearbox.jpg';
                    break;
                case 'smart-coffee-maker':
                    $filename = 'coffee-maker.jpg';
                    break;
            }
            
            // Check if the image exists in the category directory
            $imagePath = "products/{$category->slug}/{$filename}";
            $fullPath = storage_path('app/public/' . $imagePath);
            
            if (file_exists($fullPath)) {
                $product->image = $imagePath;
                $product->save();
                $this->info("Updated product {$product->name} with image path: {$imagePath}");
            } else {
                $this->warn("Warning: Image not found for product {$product->name}: {$imagePath}");
            }
        }

        $this->info('Missing images download and organization complete!');
    }
} 