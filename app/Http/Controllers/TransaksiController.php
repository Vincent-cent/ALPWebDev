<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Item;
use App\Models\MetodePembayaran;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function show($id)
    {
        $transaksi = Transaksi::with(['items.tipeItem', 'metodePembayaran', 'user'])
            ->findOrFail($id);
        
        // For authenticated users, check ownership
        if (auth()->check()) {
            if ($transaksi->user_id && $transaksi->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access to transaction');
            }
        } else {
            // For guests, check session access
            $guestTransactions = session('guest_transactions', []);
            if ($transaksi->user_id || !in_array($transaksi->id, $guestTransactions)) {
                abort(403, 'Unauthorized access to transaction');
            }
        }
        
        return view('portal.user.transaksi.transaksi', compact('transaksi'));
    }
    
    public function success($id)
    {
        $transaksi = Transaksi::with(['items.tipeItem', 'metodePembayaran', 'user'])
            ->findOrFail($id);
        
        // For authenticated users, check ownership
        if (auth()->check()) {
            if ($transaksi->user_id && $transaksi->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access to transaction');
            }
        } else {
            // For guests, check session access
            $guestTransactions = session('guest_transactions', []);
            if ($transaksi->user_id || !in_array($transaksi->id, $guestTransactions)) {
                abort(403, 'Unauthorized access to transaction');
            }
        }
        
        return view('portal.user.transaksi.success', compact('transaksi'));
    }
    
    public function debug($id)
    {
        $transaksi = Transaksi::with(['items.tipeItem', 'metodePembayaran', 'user'])
            ->findOrFail($id);
        
        // For authenticated users, check ownership
        if (auth()->check()) {
            if ($transaksi->user_id && $transaksi->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access to transaction');
            }
        } else {
            // For guests, check session access
            $guestTransactions = session('guest_transactions', []);
            if ($transaksi->user_id || !in_array($transaksi->id, $guestTransactions)) {
                abort(403, 'Unauthorized access to transaction');
            }
        }
        
        return response()->json([
            'transaction' => $transaksi,
            'midtrans_config' => [
                'server_key' => config('midtrans.server_key') ? 'SET' : 'NOT SET',
                'client_key' => config('midtrans.client_key') ? 'SET' : 'NOT SET',
                'is_production' => config('midtrans.is_production'),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        Log::info('TransaksiController@store called with data: ', $request->all());
        
        try {
            $request->validate([
                'game_id' => 'required|exists:games,id',
                'user_id' => 'required|string',
                'server_id' => 'nullable|string',
                'item_id' => 'required|exists:items,id',
                'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
                'phone' => 'required|string',
                'promo_code' => 'nullable|string'
            ]);
            
            $item = Item::with('tipeItem')->findOrFail($request->item_id);
            $metodePembayaran = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
            
            $subtotal = $item->harga;
            $adminFee = $metodePembayaran->fee;
            $discount = 0;
            $promoId = null;
            
            // Check promo code validity and tipe_item compatibility
            if ($request->promo_code) {
                $promo = PromoCode::where('code', $request->promo_code)
                    ->where('kuota', '>', 0)
                    ->where('start_at', '<=', now())
                    ->where('end_at', '>=', now())
                    ->where('tipe_item_id', $item->tipe_item_id)
                    ->first();
                
                if ($promo) {
                    $discount = min(
                        ($subtotal * $promo->discount_percent / 100),
                        $promo->discount_amount ?? PHP_FLOAT_MAX
                    );
                    $promoId = $promo->id;
                }
            }
            
            $total = $subtotal + $adminFee - $discount;
            
            return DB::transaction(function () use ($request, $item, $metodePembayaran, $total, $subtotal, $discount, $promoId) {
                // Generate unique order ID for Midtrans
                $orderId = 'INV-' . strtoupper(Str::random(10));
                
                // Get user ID (null for guests)
                $userId = auth()->check() ? auth()->id() : null;
                
                // Check if user selected saldo payment
            if ($metodePembayaran->type === 'saldo') {
                if (!auth()->check()) {
                    throw new \Exception('You must be logged in to use saldo payment.');
                }
                
                $userSaldo = auth()->user()->getOrCreateSaldo();
                if (!$userSaldo->hasEnoughBalance($total)) {
                    throw new \Exception('Insufficient saldo balance. Please top up your saldo first.');
                }
                
                // Deduct from saldo immediately for saldo payment
                $userSaldo->deductBalance($total);
                
                // Create transaksi with immediate payment
                $transaksi = Transaksi::create([
                    'user_id' => $userId,
                    'metode_pembayaran_id' => $metodePembayaran->id,
                    'midtrans_order_id' => $orderId,
                    'total' => $total,
                    'paid_at' => now(), // Immediate payment
                    'expired_at' => null,
                ]);
                
                // Create transaksi item
                $transaksi->items()->create([
                    'tipe_item_id' => $item->tipe_item_id,
                    'quantity' => 1,
                    'price' => $subtotal - $discount,
                    'promo_code_id' => $promoId,
                ]);
                
                // Decrease promo quota after successful creation
                if ($promoId) {
                    PromoCode::where('id', $promoId)->decrement('kuota');
                }
                
                return redirect()->route('transaksi.success', $transaksi->id)
                    ->with('success', 'Payment successful with TOSHOP Saldo!');
            }
                $transaksi = Transaksi::create([
                    'user_id' => $userId,
                    'metode_pembayaran_id' => $metodePembayaran->id,
                    'midtrans_order_id' => $orderId,
                    'total' => $total,
                    'paid_at' => null,
                    'expired_at' => now()->addHours(24), // 24 hour expiry
                ]);
                
                // For guest users, store transaction ID in session
                if (!auth()->check()) {
                    $guestTransactions = session('guest_transactions', []);
                    $guestTransactions[] = $transaksi->id;
                    session(['guest_transactions' => $guestTransactions]);
                }
                
                // Create transaksi item
                $transaksi->items()->create([
                    'tipe_item_id' => $item->tipe_item_id,
                    'quantity' => 1,
                    'price' => $subtotal - $discount,
                    'promo_code_id' => $promoId,
                ]);
                
                // Decrease promo quota after successful creation
                if ($promoId) {
                    PromoCode::where('id', $promoId)->decrement('kuota');
                }
                
                //  Midtrans configuration
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
                
                // Disable SSL verification for local development
                \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
                
                // Configure enabled payments based on user's selection
                $enabledPayments = [];
                $paymentOptions = [];
                
                switch($metodePembayaran->type) {
                    case 'bank_transfer':
                        $enabledPayments = ['bank_transfer'];
                        // For specific banks, we can specify which bank
                        $bank = $this->getBankFromPaymentMethod($metodePembayaran->name);
                        if ($bank) {
                            $paymentOptions['bank_transfer'] = ['bank' => [$bank]];
                        }
                        break;
                    case 'qris':
                        // For QRIS, try multiple configurations to ensure compatibility
                        $enabledPayments = ['qris', 'gopay', 'shopeepay'];
                        break;
                    case 'saldo':
                        // Saldo payments are handled above, this shouldn't reach here
                        break;
                    default:
                        // For unknown payment types, show bank transfer as fallback
                        $enabledPayments = ['bank_transfer'];
                        break;
                }
                
                // Create Midtrans transaction
                $payload = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $total,
                    ],
                    'customer_details' => [
                        'first_name' => auth()->check() ? (auth()->user()->name ?? 'User') : 'Guest',
                        'phone' => $request->phone,
                    ],
                    'item_details' => [[
                        'id' => $item->id,
                        'price' => (int) $total, // Total includes item price + admin fee - discount
                        'quantity' => 1,
                        'name' => $item->nama . ' + Admin Fee',
                    ]],
                    'enabled_payments' => $enabledPayments,
                    'callbacks' => [
                        'finish' => route('transaksi.success', $transaksi->id),
                    ],
                ];
                
                // Add payment options if specified
                if (!empty($paymentOptions)) {
                    $payload['payment_options'] = $paymentOptions;
                }
                
                try {
                    Log::info('Creating Midtrans Snap token with payload:', $payload);
                    
                    // Suppress PHP warnings during Midtrans call
                    $oldErrorReporting = error_reporting(E_ERROR | E_PARSE);
                    
                    $snapToken = \Midtrans\Snap::getSnapToken($payload);
                    
                    // Restore original error reporting
                    error_reporting($oldErrorReporting);
                    
                    Log::info('Midtrans Snap token created successfully:', ['token' => substr($snapToken, 0, 30) . '...']);
                    
                    $transaksi->update([
                        'midtrans_transaction_id' => $snapToken,
                    ]);
                } catch (\Exception $e) {
                    // Restore error reporting in case of exception
                    if (isset($oldErrorReporting)) {
                        error_reporting($oldErrorReporting);
                    }
                    
                    Log::error('Midtrans error details:', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'payload' => $payload,
                        'config' => [
                            'server_key' => config('midtrans.server_key') ? 'SET' : 'NOT SET',
                            'is_production' => config('midtrans.is_production')
                        ]
                    ]);
                    
                    // Still create transaction but without snap token for debugging
                    return redirect()->route('transaksi.show', $transaksi->id)
                        ->with('error', 'Payment system initialization failed: ' . $e->getMessage());
                }
                
                return redirect()->route('transaksi.show', $transaksi->id)
                    ->with('success', 'Transaksi berhasil dibuat!');
            });
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Transaction creation failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi. Silakan coba lagi.')
                        ->withInput();
        }
    }
    
    public function callback(Request $request)
    {
        // Initialize Midtrans configuration
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
        
        // Disable SSL verification for local development
        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        
        try {
            // Get notification from Midtrans
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? 'accept';
            
            Log::info('Midtrans callback received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);
            
            // Find the transaction
            $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();
            
            if (!$transaksi) {
                Log::error('Transaction not found for order_id: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }
            
            // Update transaction based on status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    // TODO: Set transaction status to challenge
                    $transaksi->update([
                        'midtrans_status' => 'challenge',
                        'midtrans_payment_type' => $notification->payment_type,
                    ]);
                } else if ($fraudStatus == 'accept') {
                    // TODO: Set transaction status to success
                    $transaksi->update([
                        'midtrans_status' => 'capture',
                        'midtrans_payment_type' => $notification->payment_type,
                        'paid_at' => now(),
                    ]);
                }
            } else if ($transactionStatus == 'settlement') {
                // TODO: Set transaction status to success
                $transaksi->update([
                    'midtrans_status' => 'settlement',
                    'midtrans_payment_type' => $notification->payment_type,
                    'paid_at' => now(),
                ]);
            } else if ($transactionStatus == 'pending') {
                // TODO: Set transaction status to pending
                $transaksi->update([
                    'midtrans_status' => 'pending',
                    'midtrans_payment_type' => $notification->payment_type,
                ]);
            } else if ($transactionStatus == 'deny') {
                // TODO: Set transaction status to failed
                $transaksi->update([
                    'midtrans_status' => 'deny',
                    'midtrans_payment_type' => $notification->payment_type,
                ]);
            } else if ($transactionStatus == 'expire') {
                // TODO: Set transaction status to expired
                $transaksi->update([
                    'midtrans_status' => 'expire',
                    'midtrans_payment_type' => $notification->payment_type,
                ]);
            } else if ($transactionStatus == 'cancel') {
                // TODO: Set transaction status to canceled
                $transaksi->update([
                    'midtrans_status' => 'cancel',
                    'midtrans_payment_type' => $notification->payment_type,
                ]);
            }
            
            // Store additional Midtrans data if available
            if (isset($notification->va_numbers) && !empty($notification->va_numbers)) {
                $transaksi->update([
                    'midtrans_va_number' => $notification->va_numbers[0]->va_number ?? null,
                ]);
            } else if (isset($notification->permata_va_number)) {
                $transaksi->update([
                    'midtrans_va_number' => $notification->permata_va_number,
                ]);
            } else if (isset($notification->bca_va_number)) {
                $transaksi->update([
                    'midtrans_va_number' => $notification->bca_va_number,
                ]);
            }
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Map payment method name to Midtrans bank code
     */
    private function getBankFromPaymentMethod($paymentMethodName)
    {
        $bankMapping = [
            'BCA Virtual Account' => 'bca',
            'BRI Virtual Account' => 'bri',
            'BNI Virtual Account' => 'bni',
            'Mandiri Virtual Account' => 'echannel',
            'Permata Virtual Account' => 'permata',
            'BNC Virtual Account' => 'other',
            'Danamon Virtual Account' => 'other',
            'CIMB Virtual Account' => 'cimb',
            'BSI Virtual Account' => 'other',
            'BTN Virtual Account' => 'other',
        ];
        
        return $bankMapping[$paymentMethodName] ?? null;
    }
}