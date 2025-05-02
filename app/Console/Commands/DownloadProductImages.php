<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DownloadProductImages extends Command
{
    protected $signature = 'products:download-images';
    protected $description = 'Download and organize product images';

    public function handle()
    {
        // Define image URLs for each category
        $categoryImages = [
            'electronics' => [
                'smartphone.jpg' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80',
                'laptop.jpg' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80',
                'headphones.jpg' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                'smartwatch.jpg' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80',
                'earbuds.jpg' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
                'rog-strix.jpg' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=800&q=80',
                'logitech-gpro.jpg' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=800&q=80',
            ],
            'clothing' => [
                'tshirt.jpg' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80',
                'jacket.jpg' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80',
                'shoes.jpg' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80',
                'denim-jacket.jpg' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80',
            ],
            'books' => [
                'programming.jpg' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=800&q=80',
                'business.jpg' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=800&q=80',
                'novel.jpg' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800&q=80',
            ],
            'watches' => [
                'chronograph.jpg' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=800&q=80',
                'diver.jpg' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=800&q=80',
            ],
            'sports-outdoors' => [
                'yoga-mat.jpg' => 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=800&q=80',
                'tent.jpg' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80',
            ],
            'home-kitchen' => [
                'coffee-maker.jpg' => 'https://images.unsplash.com/photo-1570486916331-9d0a0d8a0c8a?w=800&q=80',
                'cookware.jpg' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&q=80',
                'knife-set.jpg' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&q=80',
            ],
            'gears' => [
                'gear-set.jpg' => 'https://images.unsplash.com/photo-1581092921461-39b9d08a9b21?w=800&q=80',
                'gearbox.jpg' => 'https://images.unsplash.com/photo-1581092921461-39b9d08a9b21?w=800&q=80',
                'logitech-gpro.jpg' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=800&q=80',
                'ROG-Strix.png' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
            ],
            'laptops' => [
                'msi.png' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80',
                'lenovo.png' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80',
                'dell-xps.png' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80',
                'rog-strix.jpg' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=800&q=80',
            ],
        ];

        // Create base directory if it doesn't exist
        $baseDir = storage_path('app/public/products');
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Download and organize images
        foreach ($categoryImages as $category => $images) {
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
                case 'dell-xps-15':
                    $filename = 'dell-xps.png';
                    break;
                case 'industrial-gear-set':
                    $filename = 'gear-set.jpg';
                    break;
                case 'precision-gearbox':
                    $filename = 'gearbox.jpg';
                    break;
                case 'wireless-earbuds':
                    $filename = 'earbuds.jpg';
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

        $this->info('Image download and organization complete!');
    }
} 