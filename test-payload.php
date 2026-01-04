<?php
$apiId = 'M251129BGUM1758QB';
$apiKey = '1ab829e6b779a31bfc7048d60cc20791a4a644a44b79029357dd97a6efc6082e';
$orderId = 'GAME-TEST123';

$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => 'ML55',
    'tujuan'      => '95349700',
    'signature'   => md5($apiId.$apiKey.$orderId),
];

echo 'Test Payload:' . PHP_EOL;
echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
echo 'Signature: ' . md5($apiId.$apiKey.$orderId) . PHP_EOL;
echo 'Full string to hash: ' . $apiId.$apiKey.$orderId . PHP_EOL;
echo PHP_EOL;

// Check last transaksi 
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$transaksi = \App\Models\Transaksi::latest()->first();
if ($transaksi) {
    echo "Latest Transaksi ID: " . $transaksi->id . PHP_EOL;
    echo "Game User ID: " . $transaksi->game_user_id . PHP_EOL;
    echo "Game Server ID: " . $transaksi->game_server_id . PHP_EOL;
    echo "Game User ID Type: " . gettype($transaksi->game_user_id) . PHP_EOL;
    
    $item = $transaksi->items()->first();
    if ($item) {
        echo "TransaksiItem item_id: " . $item->item_id . PHP_EOL;
        
        $actualItem = \App\Models\Item::find($item->item_id);
        if ($actualItem) {
            echo "Actual Item ID: " . $actualItem->id . PHP_EOL;
            echo "Actual Item item_id (product code): " . $actualItem->item_id . PHP_EOL;
        } else {
            echo "ERROR: Item not found with ID: " . $item->item_id . PHP_EOL;
        }
    }
}
