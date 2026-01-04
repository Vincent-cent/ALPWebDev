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

$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => 'ML55',
    'tujuan'      => '95349700',
    'signature'   => $signature,
];

echo "=== APIGames Test Request ===" . PHP_EOL;
echo "API URL: " . $apiUrl . PHP_EOL;
echo "Order ID: " . $orderId . PHP_EOL;
echo "Signature: " . $signature . PHP_EOL;
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . PHP_EOL;
echo PHP_EOL;

echo "Sending request..." . PHP_EOL;
$response = Http::asJson()->post($apiUrl, $payload);

echo "Status Code: " . $response->status() . PHP_EOL;
echo "Response: " . PHP_EOL;
echo json_encode($response->json(), JSON_PRETTY_PRINT) . PHP_EOL;
