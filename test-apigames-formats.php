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
    'produk'      => '1',
    'tujuan'      => '95349700',
    'signature'   => $signature,
];

echo "=== Test 1: Http::post (default) ===" . PHP_EOL;
$response1 = Http::post($apiUrl, $payload);
echo "Response: " . json_encode($response1->json()) . PHP_EOL;
echo PHP_EOL;

echo "=== Test 2: Http::post with withoutVerifying ===" . PHP_EOL;
$response2 = Http::withoutVerifying()->post($apiUrl, $payload);
echo "Response: " . json_encode($response2->json()) . PHP_EOL;
echo PHP_EOL;

echo "=== Test 3: Http::asForm (explicit form data) ===" . PHP_EOL;
$response3 = Http::asForm()->post($apiUrl, $payload);
echo "Response: " . json_encode($response3->json()) . PHP_EOL;
echo PHP_EOL;

echo "=== Test 4: Http::asJson (JSON format) ===" . PHP_EOL;
$response4 = Http::asJson()->post($apiUrl, $payload);
echo "Response: " . json_encode($response4->json()) . PHP_EOL;
