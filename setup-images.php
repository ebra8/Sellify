<?php

// Function to resize an image
function resizeImage($sourcePath, $targetPath, $width = 300, $height = 300) {
    // Get the image type
    $imageInfo = getimagesize($sourcePath);
    $imageType = $imageInfo[2];

    // Create image from source
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        default:
            return false;
    }

    // Create new image
    $newImage = imagecreatetruecolor($width, $height);

    // Resize image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, imagesx($sourceImage), imagesy($sourceImage));

    // Save the resized image
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $targetPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $targetPath, 9);
            break;
    }

    // Free up memory
    imagedestroy($sourceImage);
    imagedestroy($newImage);

    return true;
}

// Process product images
$productDir = __DIR__ . '/public/images/products';
$files = glob($productDir . '/*.{jpg,jpeg,png}', GLOB_BRACE);

foreach ($files as $file) {
    $filename = basename($file);
    $targetPath = $productDir . '/resized_' . $filename;
    
    if (resizeImage($file, $targetPath)) {
        // Replace original with resized version
        unlink($file);
        rename($targetPath, $file);
        echo "Resized: $filename\n";
    }
}

// Process category images (which are using product images)
$categoryDir = __DIR__ . '/public/images/categories';
if (!is_dir($categoryDir)) {
    mkdir($categoryDir, 0755, true);
}

// Copy and resize product images for categories
$categoryImages = [
    'Electronics' => 'product5.jpg',
    'Clothing' => 'product2.jpg',
    'Home & Kitchen' => 'product7.jpg',
    'Books' => 'product3.jpg',
    'Sports & Outdoors' => 'product4.jpg'
];

foreach ($categoryImages as $category => $productImage) {
    $sourcePath = $productDir . '/' . $productImage;
    $targetPath = $categoryDir . '/' . strtolower(str_replace(' ', '_', $category)) . '.jpg';
    
    if (resizeImage($sourcePath, $targetPath)) {
        echo "Created category image for: $category\n";
    }
}

echo "Image resizing complete!\n"; 