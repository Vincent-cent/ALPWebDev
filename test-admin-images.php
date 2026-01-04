<?php
require 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Game;
use App\Models\BannerPromo;

echo "=== Checking Admin-Uploaded Images ===\n\n";

echo "GAMES:\n";
$games = Game::all();
foreach ($games as $game) {
    echo "Game: {$game->name}\n";
    echo "  Image path in DB: {$game->image}\n";
    
    // Check various paths
    $paths = [
        'public_path($image)' => public_path($game->image),
        'storage_path(app/public/$image)' => storage_path('app/public/' . $game->image),
        'base_path(storage/app/public/$image)' => base_path('storage/app/public/' . $game->image),
    ];
    
    foreach ($paths as $label => $path) {
        $exists = file_exists($path) ? "✓ EXISTS" : "✗ NOT FOUND";
        echo "    $label: $exists\n";
    }
    echo "\n";
}

echo "\nBANNERS:\n";
$banners = BannerPromo::all();
foreach ($banners as $banner) {
    echo "Banner: {$banner->name}\n";
    echo "  Image path in DB: {$banner->image}\n";
    
    $paths = [
        'public_path($image)' => public_path($banner->image),
        'storage_path(app/public/$image)' => storage_path('app/public/' . $banner->image),
        'base_path(storage/app/public/$image)' => base_path('storage/app/public/' . $banner->image),
    ];
    
    foreach ($paths as $label => $path) {
        $exists = file_exists($path) ? "✓ EXISTS" : "✗ NOT FOUND";
        echo "    $label: $exists\n";
    }
    echo "\n";
}

echo "\n=== Checking Storage Symlink ===\n";
$symlink = public_path('storage');
if (is_link($symlink)) {
    echo "✓ Storage symlink EXISTS\n";
    echo "  Links to: " . readlink($symlink) . "\n";
} else {
    echo "✗ Storage symlink NOT FOUND\n";
    echo "  Expected at: $symlink\n";
}

echo "\n=== Checking storage/app/public/ directory ===\n";
$storagePublic = storage_path('app/public');
if (is_dir($storagePublic)) {
    echo "✓ Directory exists: $storagePublic\n";
    $files = glob($storagePublic . '/*');
    if (count($files) > 0) {
        echo "  Files in directory:\n";
        foreach (array_slice($files, 0, 10) as $file) {
            echo "    - " . basename($file) . "\n";
        }
    } else {
        echo "  Directory is empty\n";
    }
} else {
    echo "✗ Directory NOT FOUND: $storagePublic\n";
}
