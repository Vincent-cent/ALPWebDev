<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$apiUrl = env('APIGAMES_API_URL');
$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');

$orderId = 'DEBUG-' . strtoupper(\Illuminate\Support\Str::random(6));

echo "=== Debug APIGames Parameter ===" . PHP_EOL;
echo "API ID: " . $apiId . PHP_EOL;
echo "API Key: " . substr($apiKey, 0, 10) . "..." . PHP_EOL;
echo "Order ID: " . $orderId . PHP_EOL;
echo "Full String for Signature: " . $apiId . $apiKey . $orderId . PHP_EOL;
echo "Signature (md5): " . md5($apiId.$apiKey.$orderId) . PHP_EOL;
echo PHP_EOL;

// Test tanpa signature
echo "=== Test 1: Tanpa Signature ===" . PHP_EOL;
$payload1 = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
];
$response1 = Http::post($apiUrl, $payload1);
echo "Response: " . $response1->body() . PHP_EOL;
echo PHP_EOL;

// Test dengan signature yang salah
echo "=== Test 2: Dengan Signature Salah ===" . PHP_EOL;
$payload2 = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'signature'   => 'wrongsignature',
];
$response2 = Http::post($apiUrl, $payload2);
echo "Response: " . $response2->body() . PHP_EOL;
echo PHP_EOL;

// Test dengan signature benar
echo "=== Test 3: Dengan Signature Benar ===" . PHP_EOL;
$payload3 = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'signature'   => md5($apiId.$apiKey.$orderId),
];
$response3 = Http::post($apiUrl, $payload3);
echo "Response: " . $response3->body() . PHP_EOL;
