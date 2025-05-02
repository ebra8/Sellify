<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get all categories
        $categories = Category::all();

        $products = [
            [
                'name' => 'Smart Coffee Maker',
                'description' => 'Programmable coffee maker with mobile app control',
                'price' => 129.99,
                'image' => 'product1.jpg',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'is_active' => true,
                'stock' => 50,
                'slug' => 'smart-coffee-maker'
            ],
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Comfortable and stylish cotton t-shirt',
                'price' => 24.99,
                'image' => 'product2.jpg',
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'is_active' => true,
                'stock' => 100,
                'slug' => 'premium-cotton-t-shirt'
            ],
            [
                'name' => 'Programming Guide',
                'description' => 'Comprehensive guide to modern programming',
                'price' => 49.99,
                'image' => 'product3.jpg',
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'is_active' => true,
                'stock' => 30,
                'slug' => 'programming-guide'
            ],
            [
                'name' => 'Premium Yoga Mat',
                'description' => 'High-quality non-slip yoga mat',
                'price' => 39.99,
                'image' => 'product4.jpg',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()->id,
                'is_active' => true,
                'stock' => 40,
                'slug' => 'premium-yoga-mat'
            ],
            [
                'name' => 'Flagship Smartphone',
                'description' => 'Latest smartphone with advanced features',
                'price' => 899.99,
                'image' => 'product5.jpg',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'is_active' => true,
                'stock' => 25,
                'slug' => 'flagship-smartphone'
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless noise-canceling headphones',
                'price' => 199.99,
                'image' => 'product6.jpg',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'is_active' => true,
                'stock' => 35,
                'slug' => 'wireless-headphones'
            ],
            [
                'name' => 'Non-stick Cookware Set',
                'description' => 'Complete set of non-stick cookware',
                'price' => 149.99,
                'image' => 'product7.jpg',
                'category_id' => $categories->where('name', 'Home & Kitchen')->first()->id,
                'is_active' => true,
                'stock' => 20,
                'slug' => 'non-stick-cookware-set'
            ],
            [
                'name' => 'Bestseller Novel',
                'description' => 'Award-winning fiction novel',
                'price' => 19.99,
                'image' => 'product8.jpg',
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'is_active' => true,
                'stock' => 60,
                'slug' => 'bestseller-novel'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
} 