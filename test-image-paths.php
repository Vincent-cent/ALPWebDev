<?php
require 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Game;
use App\Models\BannerPromo;

echo "=== Games Image Paths ===\n";
$games = Game::all();
foreach ($games->take(5) as $game) {
    echo "Game: " . $game->name . "\n";
    echo "  Image path in DB: " . $game->image . "\n";
    echo "  Public path: " . public_path($game->image) . "\n";
    echo "  File exists: " . (file_exists(public_path($game->image)) ? "YES" : "NO") . "\n";
    echo "\n";
}

echo "=== Banner Image Paths ===\n";
$banners = BannerPromo::all();
foreach ($banners->take(5) as $banner) {
    echo "Banner: " . $banner->name . "\n";
    echo "  Image path in DB: " . $banner->image . "\n";
    echo "  Public path: " . public_path($banner->image) . "\n";
    echo "  File exists: " . (file_exists(public_path($banner->image)) ? "YES" : "NO") . "\n";
    echo "\n";
}

echo "\n=== Check public directories ===\n";
echo "Contents of public/:\n";
$files = glob(public_path('*'));
foreach ($files as $file) {
    if (is_dir($file)) {
        echo "  [DIR] " . basename($file) . "/\n";
    }
}

echo "\nContents of public/images/:\n";
if (is_dir(public_path('images'))) {
    $files = glob(public_path('images/*'));
    foreach ($files as $file) {
        echo "  " . basename($file) . "\n";
    }
}

echo "\nContents of public/banner/:\n";
if (is_dir(public_path('banner'))) {
    $files = glob(public_path('banner/*'));
    foreach ($files as $file) {
        echo "  " . basename($file) . "\n";
    }
} else {
    echo "  Directory does not exist\n";
}
