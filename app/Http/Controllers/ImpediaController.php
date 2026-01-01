<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImpediaController extends Controller
{
    public function order(Request $request)
    {
        $request->validate([
            'userid' => 'required|string',
            'product_id' => 'required|string'
        ]);

        $refId = 'INV' . time();

        // Gabungkan userid + serverid jika ada
        $customerId = $request->userid;
        if ($request->serverid) {
            $customerId .= '|' . $request->serverid;
        }

        $payload = [
            'secret_key'  => env('IMPEDIA_SECRET_KEY'),
            'product_id'  => $request->product_id,
            'customer_id' => $customerId,
            'ref_id'      => $refId,
        ];

$response = Http::withoutVerifying()->post(
    env('IMPEDIA_API_URL') . '/order',
    $payload
);
dd($response->status(), $response->body());
dd([
    'url' => env('IMPEDIA_API_URL') . '/api/order',
    'status' => $response->status(),
    'raw' => $response->body(),
    'headers' => $response->headers(),
]);

        return redirect()->back()->with('result', [
            'request' => $payload,
            'status'  => $response->status(),
            'response'=> $response->json(),
        ]);
    }
}
