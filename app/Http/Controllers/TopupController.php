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


    public function __construct()
    {
        $this->apiUrl = env('APIGAMES_API_URL');
        $this->apiId  = env('APIGAMES_API_ID');
        $this->apiKey = env('APIGAMES_API_KEY');
    }


    public function createOrder(Request $req)
    {
        $validated = $req->validate([
            'userid'   => 'required|numeric',
            'serverid' => 'required|numeric',
            'diamond'  => 'required|string',
        ]);

        $orderId = 'INV' . time();

        Order::create([
            'order_id'     => $orderId,
            'user_id_ml'   => $validated['userid'],
            'server_id_ml' => $validated['serverid'],
            'product_id'   => $validated['diamond'],
            'status'       => 'pending'
        ]);

        $response = Http::post('https://v1.apigames.id/v2/transaksi', [
            'ref_id'      => $orderId,
            'merchant_id' => $this->apiId,
            'produk'      => $validated['diamond'],
            'tujuan'      => $req->userid,
            'server_id'   => $req->serverid ?? '',
            'signature'   => md5($this->apiId . ':' . $this->apiKey . ':' . $orderId),
        ]);


        return view('order-result', [
            'order_id'   => $orderId,
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
