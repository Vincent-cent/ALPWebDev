<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$apiUrl = env('APIGAMES_API_URL');
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');

$orderId = 'TEST-' . strtoupper(\Illuminate\Support\Str::random(8));
$signature = md5($apiId.$apiKey.$orderId);

// Format dengan server_id (seperti yang berhasil di Januari 3)
$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'server_id'   => '2503',  // ADD THIS!
    'signature'   => $signature,
];

echo "=== Test dengan server_id (Januari 3 Format) ===" . PHP_EOL;
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . PHP_EOL;
echo PHP_EOL;

$response = Http::post($apiUrl, $payload);

echo "Status: " . $response->status() . PHP_EOL;
echo "Response: " . PHP_EOL;
echo json_encode($response->json(), JSON_PRETTY_PRINT) . PHP_EOL;
