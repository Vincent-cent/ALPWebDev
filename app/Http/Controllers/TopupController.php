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


    public function order(Request $req)
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

$response = Http::asJson()->post(
    'https://v1.apigames.id/transaksi',
    [
        'ref_id'      => $orderId,
        'merchant_id' => $this->apiId,
        'produk'      => $validated['diamond'],
        'tujuan'      => $validated['userid'].'|'.$validated['serverid'],
        'signature'   => md5($this->apiId.$this->apiKey.$orderId),
    ]
);

dd([
    'request_payload' => [
        'ref_id'      => $orderId,
        'merchant_id' => $this->apiId,
        'produk'      => $validated['diamond'],
        'tujuan'      => $validated['userid'].'|'.$validated['serverid'],
        'signature'   => md5($this->apiId.$this->apiKey.$orderId),
    ],
    'status'  => $response->status(),
    'body'    => $response->body(),
        $response->status(),
    $response->json()
]);

        return view('order-result', [
            'order_id'   => $orderId,
            'api_result' => $response->json()
        ]);
    }

    public function resellerCallback(Request $req)
    {
        $expectedSignature = md5(
            $this->apiId .
                $this->apiKey .
                $req->ref_id
        );

        if ($req->signature !== $expectedSignature) {
            return response('Invalid Signature', 403);
        }

        $order = Order::where('order_id', $req->ref_id)->first();
        if (!$order) return response('Order Not Found', 404);

        $order->status = $req->status;
        $order->save();

        return response('OK', 200);
    }
}
