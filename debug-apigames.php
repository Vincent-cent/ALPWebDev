<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test APIGames signature
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');
$orderId = 'APIGAMES-TEST123';

$signature1 = md5($apiId.$apiKey.$orderId);
$signature2 = md5($apiId.':'.$apiKey.':'.$orderId);

echo "API ID: " . $apiId . "\n";
echo "API Key: " . $apiKey . "\n";
echo "Order ID: " . $orderId . "\n";
echo "Signature (no colon): " . $signature1 . "\n";
echo "Signature (with colon): " . $signature2 . "\n";

// Check transaksi
$transaksi = \App\Models\Transaksi::find(7);
if ($transaksi) {
    echo "\nTransaksi ID: " . $transaksi->id . "\n";
    echo "Game User ID: " . ($transaksi->game_user_id ?? 'NULL') . "\n";
    echo "Game Server ID: " . ($transaksi->game_server_id ?? 'NULL') . "\n";
    
    $transItem = $transaksi->items()->first();
    if ($transItem) {
        echo "\nTransaksi Item ID: " . $transItem->id . "\n";
        echo "Transaksi Item item_id (FK): " . $transItem->item_id . "\n";
        
        // Get actual Item
        $actualItem = \App\Models\Item::find($transItem->item_id);
        if ($actualItem) {
            echo "\n=== ACTUAL ITEM ===\n";
            echo "ID: " . $actualItem->id . "\n";
            echo "Nama: " . $actualItem->nama . "\n";
            echo "Item ID (product code): " . $actualItem->item_id . "\n";
            echo "Harga: " . $actualItem->harga . "\n";
            echo "All fields: " . json_encode($actualItem->getAttributes(), JSON_PRETTY_PRINT) . "\n";
        }
    }
}
