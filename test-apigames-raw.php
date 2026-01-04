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

echo "=== Raw Response Analysis ===" . PHP_EOL;
echo "Request Payload: " . json_encode($payload) . PHP_EOL;
echo PHP_EOL;

$response = Http::post($apiUrl, $payload);

echo "Status: " . $response->status() . PHP_EOL;
echo "Headers: " . PHP_EOL;
var_dump($response->headers());
echo "Body: " . $response->body() . PHP_EOL;
echo "JSON: " . json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
