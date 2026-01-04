<?php
$apiUrl = 'https://v1.apigames.id/v2/transaksi';
$apiId = 'M251129BGUM1758QB';
$apiKey = '1ab829e6b779a31bfc7048d60cc20791a4a644a44b79029357dd97a6efc6082e';
$orderId = 'CURL-' . strtoupper(bin2hex(random_bytes(4)));
$signature = md5($apiId.$apiKey.$orderId);

$postData = [
    'ref_id'      => $orderId,
    'merchant_id' => $apiId,
    'produk'      => 'ML55',
    'tujuan'      => '95349700',
    'signature'   => $signature,
];

echo "=== Direct CURL Test ===" . PHP_EOL;
echo "URL: $apiUrl" . PHP_EOL;
echo "Order ID: $orderId" . PHP_EOL;
echo "Signature: $signature" . PHP_EOL;
echo "POST Data: " . json_encode($postData, JSON_PRETTY_PRINT) . PHP_EOL;
echo PHP_EOL;

// Using file_get_contents with stream context
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded' . "\r\n",
        'content' => http_build_query($postData),
        'timeout' => 30
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
];

echo "Sending request..." . PHP_EOL;
$context = stream_context_create($options);
$result = @file_get_contents($apiUrl, false, $context);

if ($result === false) {
    echo "Error: " . $http_response_header[0] . PHP_EOL;
} else {
    echo "Status: HTTP/1.1 (check headers)" . PHP_EOL;
    echo "Response: " . PHP_EOL;
    echo json_encode(json_decode($result), JSON_PRETTY_PRINT) . PHP_EOL;
}
