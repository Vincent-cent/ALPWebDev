<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$apiId = env('APIGAMES_API_ID');
$apiKey = env('APIGAMES_API_KEY');
$refId = 'APIGAMES-TEST123';
$produk = 'ML55';
$tujuan = '95349700|2503';

// Different signature formats
$sig1 = md5($apiId.$apiKey.$refId);
$sig2 = md5($apiId.':'.$apiKey.':'.$refId);
$sig3 = md5($refId.$apiKey.$apiId);
$sig4 = md5($apiId.$apiKey.$produk.$tujuan);
$sig5 = md5($apiId.$apiKey.$refId.$produk.$tujuan);

// Based on TopupController format
$sig_topup = md5($apiId.$apiKey.$refId);

echo "=== APIGames Signature Testing ===\n\n";
echo "API ID: " . $apiId . "\n";
echo "API Key: " . $apiKey . "\n";
echo "Ref ID: " . $refId . "\n";
echo "Produk: " . $produk . "\n";
echo "Tujuan: " . $tujuan . "\n\n";

echo "Format 1 (apiId+apiKey+refId): " . $sig1 . "\n";
echo "Format 2 (apiId:apiKey:refId): " . $sig2 . "\n";
echo "Format 3 (refId+apiKey+apiId): " . $sig3 . "\n";
echo "Format 4 (apiId+apiKey+produk+tujuan): " . $sig4 . "\n";
echo "Format 5 (apiId+apiKey+refId+produk+tujuan): " . $sig5 . "\n";
echo "TopupController Format: " . $sig_topup . "\n";

// Check last successful transaction
$transaksi = \App\Models\Transaksi::where('apigames_status', 'Berhasil')->orWhere('apigames_status', 'SUCCESS')->first();
if ($transaksi) {
    echo "\n=== Last Successful Transaction ===\n";
    echo "ID: " . $transaksi->id . "\n";
    echo "APIGames Order ID: " . $transaksi->apigames_order_id . "\n";
    echo "APIGames Status: " . $transaksi->apigames_status . "\n";
    echo "APIGames Response: " . $transaksi->apigames_response . "\n";
} else {
    echo "\n[INFO] No successful transaction found\n";
}
