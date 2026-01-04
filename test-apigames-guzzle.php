<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Guzzle\Client;
use GuzzleHttp\Psr7\Request;

$apiUrl = env('APIGAMES_API_URL');
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');

$orderId = 'GUZZLE-' . strtoupper(\Illuminate\Support\Str::random(6));
$signature = md5($apiId.$apiKey.$orderId);

$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'signature'   => $signature,
];

echo "=== Test dengan Guzzle Raw JSON Body ===" . PHP_EOL;
echo "Order ID: " . $orderId . PHP_EOL;
echo "Signature: " . $signature . PHP_EOL;
echo PHP_EOL;

$client = new \GuzzleHttp\Client([
    'verify' => false,
]);

try {
    // Send as raw JSON in body
    $response = $client->request('POST', $apiUrl, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'body' => json_encode($payload),
    ]);
    
    echo "Status: " . $response->getStatusCode() . PHP_EOL;
    echo "Body: " . $response->getBody() . PHP_EOL;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
