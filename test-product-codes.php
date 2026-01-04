<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;
use App\Models\Item;

$apiUrl = env('APIGAMES_API_URL');
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');

// Get all items to test
$items = Item::all();

echo "=== Testing Product Codes Sent to APIGames ===\n";
echo "Total items: " . count($items) . "\n\n";

foreach ($items->take(3) as $item) {
    echo "Item ID: {$item->id}, Product Code (item_id): {$item->item_id}, Name: {$item->nama}\n";
    
    $orderId = 'TEST-' . strtoupper(\Illuminate\Support\Str::random(6));
    $signature = md5($apiId.':'.$apiKey.':'.$orderId);
    
    $payload = [
        'ref_id'      => $orderId,
        'merchant_id' => $apiId,
        'produk'      => $item->item_id,  // Send product code
        'tujuan'      => '95349700',
        'server_id'   => '2503',
        'signature'   => $signature,
    ];
    
    $response = Http::post($apiUrl, $payload);
    $result = $response->json();
    
    if (isset($result['data'])) {
        echo "  APIGames received product_code: {$result['data']['product_code']}\n";
        echo "  APIGames product name: {$result['data']['product_detail']['name']}\n";
        echo "  Status: {$result['data']['status']}\n";
    } else {
        echo "  Error: " . ($result['error_msg'] ?? 'Unknown error') . "\n";
    }
    echo "\n";
}
