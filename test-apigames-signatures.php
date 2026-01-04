<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$apiUrl = env('APIGAMES_API_URL');
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');

$orderId = 'SIG-' . strtoupper(\Illuminate\Support\Str::random(6));
$tujuan = '95349700';
$serverId = '2503';
$produk = '1';

echo "=== Testing Different Signature Formats ===" . PHP_EOL;
echo "API ID: " . $apiId . PHP_EOL;
echo "API Key: " . substr($apiKey, 0, 10) . "..." . PHP_EOL;
echo "Ref ID: " . $orderId . PHP_EOL;
echo "Produk: " . $produk . PHP_EOL;
echo "Tujuan: " . $tujuan . PHP_EOL;
echo "Server ID: " . $serverId . PHP_EOL;
echo PHP_EOL;

$signatures = [
    'sig1' => md5($apiId.$apiKey.$orderId),                                        // Original
    'sig2' => md5($apiId.$apiKey.$orderId.$produk),                                // + produk
    'sig3' => md5($apiId.$apiKey.$orderId.$produk.$tujuan),                        // + tujuan
    'sig4' => md5($apiId.$apiKey.$orderId.$produk.$tujuan.$serverId),              // + server_id
    'sig5' => md5($apiId.':'.$apiKey.':'.$orderId),                                // with colon
    'sig6' => md5($orderId.$apiKey.$apiId),                                        // reverse order
];

foreach ($signatures as $label => $sig) {
    echo "$label: $sig" . PHP_EOL;
    
    $payload = [
        'ref_id'      => $orderId,
        'merchant_id' => $apiId,
        'produk'      => $produk,
        'tujuan'      => $tujuan,
        'server_id'   => $serverId,
        'signature'   => $sig,
    ];
    
    $response = Http::post($apiUrl, $payload);
    $result = $response->json();
    
    if (isset($result['status']) && $result['status'] == 1) {
        echo "✓ SUCCESS! Response: " . json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
        break;
    } else {
        echo "✗ Failed: " . ($result['error_msg'] ?? 'Unknown error') . PHP_EOL;
    }
    echo PHP_EOL;
}
