<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/app.php';

$images = [
    // Hero background
    'hero' => [
        'hero-bg.jpg' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=2070&auto=format&fit=crop',
    ],
    
    // Product images
    'products' => [
        'product1.jpg' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1999&auto=format&fit=crop',
        'product2.jpg' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop',
        'product3.jpg' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop',
        'product4.jpg' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?q=80&w=1964&auto=format&fit=crop',
        'product5.jpg' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?q=80&w=1974&auto=format&fit=crop',
        'product6.jpg' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=2080&auto=format&fit=crop',
        'product7.jpg' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?q=80&w=2070&auto=format&fit=crop',
        'product8.jpg' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?q=80&w=1974&auto=format&fit=crop',
    ],
    
    // Category icons
    'categories' => [
        'electronics.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'clothing.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'home.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'books.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'sports.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
    ],
    
    // Feature icons
    'features' => [
        'shipping.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'payment.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'support.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
        'returns.png' => 'https://cdn-icons-png.flaticon.com/512/3659/3659899.png',
    ],
];

// Create directories if they don't exist
foreach (array_keys($images) as $dir) {
    $path = __DIR__ . "/../public/images/{$dir}";
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }
}

// Download images
foreach ($images as $dir => $files) {
    foreach ($files as $filename => $url) {
        $path = __DIR__ . "/../public/images/{$dir}/{$filename}";
        if (!file_exists($path)) {
            $content = file_get_contents($url);
            if ($content !== false) {
                file_put_contents($path, $content);
                echo "Downloaded: {$filename}\n";
            } else {
                echo "Failed to download: {$filename}\n";
            }
        } else {
            echo "Already exists: {$filename}\n";
        }
    }
}

echo "Image setup completed!\n"; 