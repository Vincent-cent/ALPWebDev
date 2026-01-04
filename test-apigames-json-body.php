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

echo "=== Test dengan HTTP Raw Body JSON ===" . PHP_EOL;
echo "Order ID: $orderId" . PHP_EOL;
echo "Signature: $signature" . PHP_EOL;
echo PHP_EOL;

// Try sending as raw JSON body
$jsonBody = json_encode($payload);
echo "JSON Body: $jsonBody" . PHP_EOL;
echo PHP_EOL;

$response = Http::withHeaders(['Content-Type' => 'application/json'])
    ->post($apiUrl, $payload);

echo "Response Status: " . $response->status() . PHP_EOL;
echo "Response Body: " . $response->body() . PHP_EOL;
echo PHP_EOL;

// Also try sending with bodyless form
echo "=== Test dengan Http::asForm (Guzzle default) ===" . PHP_EOL;
$response2 = Http::asForm()->post($apiUrl, $payload);
echo "Response Status: " . $response2->status() . PHP_EOL;
echo "Response Body: " . $response2->body() . PHP_EOL;
