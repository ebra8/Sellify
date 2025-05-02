<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CreatePlaceholderImages extends Command
{
    protected $signature = 'products:create-placeholders';
    protected $description = 'Create placeholder images for missing products';

    public function handle()
    {
        // Define placeholder images to create
        $placeholders = [
            'home-kitchen' => [
                'coffee-maker.jpg' => 'Coffee Maker',
            ],
            'gears' => [
                'gear-set.jpg' => 'Industrial Gear Set',
                'gearbox.jpg' => 'Precision Gearbox',
            ],
        ];

        // Create base directory if it doesn't exist
        $baseDir = storage_path('app/public/products');
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Create placeholder images
        foreach ($placeholders as $category => $images) {
            // Create category directory
            $categoryDir = $baseDir . '/' . $category;
            if (!file_exists($categoryDir)) {
                mkdir($categoryDir, 0755, true);
            }

            // Create each placeholder image
            foreach ($images as $filename => $text) {
                $filePath = $categoryDir . '/' . $filename;
                
                // Skip if file already exists
                if (file_exists($filePath)) {
                    $this->info("File already exists: {$category}/{$filename}");
                    continue;
                }

                // Create a simple placeholder image
                $image = imagecreatetruecolor(800, 600);
                $bgColor = imagecolorallocate($image, 240, 240, 240);
                $textColor = imagecolorallocate($image, 100, 100, 100);
                
                // Fill background
                imagefill($image, 0, 0, $bgColor);
                
                // Add text
                $font = 5; // Built-in font
                $textWidth = imagefontwidth($font) * strlen($text);
                $textHeight = imagefontheight($font);
                $x = (800 - $textWidth) / 2;
                $y = (600 - $textHeight) / 2;
                
                imagestring($image, $font, $x, $y, $text, $textColor);
                
                // Save the image
                imagejpeg($image, $filePath, 90);
                imagedestroy($image);
                
                $this->info("Created placeholder: {$category}/{$filename}");
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

        $this->info('Placeholder images creation complete!');
    }
} 