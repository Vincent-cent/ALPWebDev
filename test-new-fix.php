<?php
require 'vendor/autoload.php';

$apiId = 'M251129BGUM1758QB';
$apiKey = '1ab829e6b779a31bfc7048d60cc20791a4a644a44b79029357dd97a6efc6082e';
$apiUrl = 'https://v1.apigames.id/v2/transaksi';

// Test signature format (with colon)
$orderId = 'TEST-' . time();
$signature = md5($apiId.':'.$apiKey.':'.$orderId);

echo "=== Testing Updated Code with asForm() and Colon Signature ===\n";
echo "Order ID: $orderId\n";
echo "Signature: $signature\n";
echo "Using: md5(\$apiId.':'.\$apiKey.':'.\$orderId)\n\n";

// Test with form-encoded data
$payload = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => '1',
    'tujuan'      => '95349700',
    'server_id'   => '2503',
    'signature'   => $signature,
];

echo "Payload:\n";
print_r($payload);

// Use Guzzle directly to test form-encoded
$client = new \GuzzleHttp\Client([
    'verify' => false,
]);

try {
    $response = $client->post($apiUrl, [
        'form_params' => $payload,
    ]);
    
    echo "\nStatus Code: " . $response->getStatusCode() . "\n";
    echo "Response Body:\n";
    $body = $response->getBody()->getContents();
    echo $body . "\n";
    
    $decoded = json_decode($body, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "\nDecoded Response:\n";
        echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
