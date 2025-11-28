<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;


class TopupController extends Controller
{
private $apiUrl;
private $apiKey;
private $apiId;


public function __construct() {
$this->apiUrl = env('APIGAMES_API_URL');
$this->apiId  = env('APIGAMES_API_ID');
$this->apiKey = env('APIGAMES_API_KEY');
}


public function createOrder(Request $req)
{
$orderId = 'INV' . time();


Order::create([
'order_id' => $orderId,
'user_id_ml' => $req->userid,
'server_id_ml' => $req->serverid,
'product_id' => $req->diamond,
'status' => 'pending'
]);


$response = Http::post($this->apiUrl . '/order', [
    'merchant_id'  => $this->apiId,          // atau api_id tergantung dokumentasi
    'signature'    => hash('sha256', $this->apiId . $orderId . $this->apiKey),
    'reference_id' => $orderId,
    'service_id'   => $req->diamond,        // kode produk MLBB seperti ML11, ML86, dll.
    'data_no'      => $req->userid,
    'data_zone'    => $req->serverid,
]);


return view('order-result', [
'order_id' => $orderId,
'api_result' => $response->json()
]);
}




public function resellerCallback(Request $req)
{
$order = Order::where('order_id', $req->reference_id)->first();
if (!$order) return response('Order Not Found', 404);


$order->status = $req->status;
$order->save();


return response('OK', 200);
}
}