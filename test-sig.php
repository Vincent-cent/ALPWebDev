<?php
$apiId = 'M251129BGUM1758QB';
$apiKey = '1ab829e6b779a31bfc7048d60cc20791a4a644a44b79029357dd97a6efc6082e';
$orderId = 'APIGAMES-K2U79NFYGH';

$fullString = $apiId.$apiKey.$orderId;
$sig = md5($fullString);

echo "API ID: " . $apiId . "\n";
echo "API Key: " . $apiKey . "\n"; 
echo "Order ID: " . $orderId . "\n";
echo "Full string to hash: " . $fullString . "\n";
echo "Full string length: " . strlen($fullString) . "\n";
echo "MD5 Signature: " . $sig . "\n";
