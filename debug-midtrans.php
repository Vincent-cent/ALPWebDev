<?php

require_once 'vendor/autoload.php';

// Load .env file
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(sprintf('%s=%s', $name, $value));
    }
}

$serverKey = getenv('MIDTRANS_SERVER_KEY');
$clientKey = getenv('MIDTRANS_CLIENT_KEY');
$isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';

echo "=== MIDTRANS CONFIGURATION DEBUG ===\n";
echo "Server Key: " . ($serverKey ? substr($serverKey, 0, 20) . '...' : 'NOT SET') . "\n";
echo "Client Key: " . ($clientKey ? substr($clientKey, 0, 20) . '...' : 'NOT SET') . "\n";
echo "Is Production: " . ($isProduction ? 'YES' : 'NO') . "\n";
echo "Server Key Format: " . (strpos($serverKey, 'Mid-server-') === 0 || strpos($serverKey, 'SB-Mid-server-') === 0 ? 'CORRECT' : 'INCORRECT - Should start with Mid-server- or SB-Mid-server-') . "\n";
echo "Client Key Format: " . (strpos($clientKey, 'Mid-client-') === 0 || strpos($clientKey, 'SB-Mid-client-') === 0 ? 'CORRECT' : 'INCORRECT - Should start with Mid-client- or SB-Mid-client-') . "\n";

// Test Midtrans configuration
try {
    \Midtrans\Config::$serverKey = $serverKey;
    \Midtrans\Config::$isProduction = $isProduction;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;
    
    // Disable SSL verification for local development
    \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;

    // Try to create a test payload
    $testPayload = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'Test User',
        ],
    ];
    
    echo "\n=== TESTING MIDTRANS CONNECTION ===\n";
    echo "Testing with payload: " . json_encode($testPayload) . "\n";
    
    $snapToken = \Midtrans\Snap::getSnapToken($testPayload);
    echo "SUCCESS: Snap token created: " . substr($snapToken, 0, 30) . "...\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== SOLUTION ===\n";
echo "If you see 'INCORRECT' format or errors above:\n";
echo "1. Go to https://dashboard.sandbox.midtrans.com/\n";
echo "2. Navigate to Settings > Access Keys\n";
echo "3. Copy the correct Server Key (starts with SB-Mid-server-)\n";
echo "4. Copy the correct Client Key (starts with SB-Mid-client-)\n";
echo "5. Update your .env file with the correct keys\n";