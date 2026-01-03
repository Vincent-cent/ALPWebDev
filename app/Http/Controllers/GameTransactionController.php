<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GameTransactionController extends Controller
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

    /**
     * Send game transaction to APIGames
     */
    public function sendToAPIGames(Request $request)
    {
        Log::info('GameTransactionController@sendToAPIGames called with data: ', $request->all());
        
        try {
            // Validate input
            $validated = $request->validate([
                'transaksi_id' => 'required|integer',
                'user_id' => 'required|string',
                'server_id' => 'nullable|string',
                'item_db_id' => 'required|integer',
            ]);

            Log::info('Validated data: ', $validated);

            // Get transaction from database
            $transaksi = Transaksi::find($validated['transaksi_id']);
            if (!$transaksi) {
                Log::error('Transaction not found: ' . $validated['transaksi_id']);
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }
            
            // Get the Item to retrieve the actual product code
            $item = Item::find($validated['item_db_id']);
            if (!$item) {
                Log::error('Item not found: ' . $validated['item_db_id']);
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }
            
            $productCode = $item->item_id; // This is the APIGames product code (e.g., "ML55", "FF5")
            
            if (!$productCode) {
                Log::error('Product code not found for item: ' . $validated['item_db_id']);
                return response()->json([
                    'success' => false,
                    'message' => 'Kode produk tidak ditemukan untuk item ini'
                ], 400);
            }
            
            Log::info('Product code found: ' . $productCode);
            
            // Generate order ID
            $orderId = 'GAME-' . strtoupper(Str::random(10));
            
            // Update transaksi with APIGames reference
            $transaksi->update([
                'apigames_order_id' => $orderId,
            ]);
            
            Log::info('Sending to APIGames with:', [
                'ref_id' => $orderId,
                'merchant_id' => $this->apiId,
                'produk' => $productCode,
                'tujuan' => $validated['user_id'],
                'server_id' => $validated['server_id'] ?? '',
            ]);
            
            // Send to APIGames
            $response = Http::post('https://v1.apigames.id/v2/transaksi', [
                'ref_id'      => $orderId,
                'merchant_id' => $this->apiId,
                'produk'      => $productCode,
                'tujuan'      => $validated['user_id'],
                'server_id'   => $validated['server_id'] ?? '',
                'signature'   => md5($this->apiId . ':' . $this->apiKey . ':' . $orderId),
            ]);
            
            $apiResult = $response->json();
            
            Log::info('APIGames response:', $apiResult);
            
            // Update transaksi with APIGames response
            $transaksi->update([
                'apigames_response' => json_encode($apiResult),
                'apigames_status' => $apiResult['status'] ?? 'pending',
            ]);
            
            return response()->json([
                'success' => true,
                'transaksi_id' => $transaksi->id,
                'apigames_order_id' => $orderId,
                'api_result' => $apiResult,
                'message' => 'Transaksi berhasil dikirim ke APIGames'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending to APIGames:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Callback from APIGames when transaction is processed
     */
    public function apiGamesCallback(Request $request)
    {
        Log::info('GameTransactionController@apiGamesCallback received:', $request->all());
        
        $expectedSignature = md5(
            $this->apiId .
                $this->apiKey .
                $request->ref_id
        );

        if ($request->signature !== $expectedSignature) {
            Log::warning('Invalid signature for callback:', [
                'received' => $request->signature,
                'expected' => $expectedSignature
            ]);
            return response('Invalid Signature', 403);
        }

        try {
            $transaksi = Transaksi::where('apigames_order_id', $request->ref_id)->first();
            if (!$transaksi) {
                Log::warning('Transaction not found for ref_id: ' . $request->ref_id);
                return response('Transaction Not Found', 404);
            }

            // Update transaksi status based on APIGames response
            $transaksi->update([
                'apigames_status' => $request->status,
                'apigames_response' => json_encode($request->all()),
            ]);
            
            Log::info('Transaction updated:', [
                'transaksi_id' => $transaksi->id,
                'status' => $request->status
            ]);

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Error processing callback:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response('Error processing callback', 500);
        }
    }
}
