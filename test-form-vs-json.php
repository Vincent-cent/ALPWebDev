<?php
require 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\Http;

$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');
$apiUrl = env('APIGAMES_API_URL');

$orderId = 'TEST-' . strtoupper(\Illuminate\Support\Str::random(6));
echo "Testing: $orderId\n";
echo "API URL: $apiUrl\n";

$signature = md5($apiId.':'.$apiKey.':'.$orderId);

$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'server_id'   => '2503',
    'signature'   => $signature,
];

echo "\n=== Test 1: Http::post() (default) ===\n";
$response1 = Http::post($apiUrl, $payload);
echo "Status: " . $response1->status() . "\n";
echo "Response: " . $response1->body() . "\n";

echo "\n=== Test 2: Http::asForm()->post() ===\n";
$response2 = Http::asForm()->post($apiUrl, $payload);
echo "Status: " . $response2->status() . "\n";
echo "Response: " . $response2->body() . "\n";
