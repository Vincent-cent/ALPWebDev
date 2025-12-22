<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaldoController extends Controller
{
    public function topup(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:100000', // Minimum 100k
                'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
                'phone' => 'required|string',
            ]);

            $metodePembayaran = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
            $amount = $request->amount;
            $adminFee = $metodePembayaran->fee;
            
            // Calculate fee for QRIS (0.7%)
            if ($metodePembayaran->type === 'qris') {
                $adminFee = $amount * 0.007; // 0.7% fee
            }
            
            $total = $amount + $adminFee;

            return DB::transaction(function () use ($request, $metodePembayaran, $amount, $adminFee, $total) {
                // Generate unique order ID for Midtrans
                $orderId = 'TOPUP-' . strtoupper(Str::random(10));

                // Ensure user has saldo record
                $saldo = auth()->user()->getOrCreateSaldo();

                // Create transaksi for saldo top-up
                $transaksi = Transaksi::create([
                    'user_id' => auth()->id(),
                    'metode_pembayaran_id' => $metodePembayaran->id,
                    'midtrans_order_id' => $orderId,
                    'total' => $total,
                    'paid_at' => null,
                    'expired_at' => now()->addHours(24),
                ]);

                // Create transaksi item for saldo top-up
                $transaksi->items()->create([
                    'tipe_item_id' => null, // Special case for saldo top-up
                    'quantity' => 1,
                    'price' => $amount,
                    'promo_code_id' => null,
                ]);

                // Initialize Midtrans configuration
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                // Create Midtrans transaction
                $payload = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $total,
                    ],
                    'customer_details' => [
                        'first_name' => auth()->user()->name,
                        'phone' => $request->phone,
                        'email' => auth()->user()->email,
                    ],
                    'item_details' => [[
                        'id' => 'saldo-topup',
                        'price' => (int) $amount,
                        'quantity' => 1,
                        'name' => 'TOSHOP Saldo Top-up Rp ' . number_format($amount),
                    ]],
                ];

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($payload);
                    $transaksi->update([
                        'midtrans_transaction_id' => $snapToken,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Midtrans error: ' . $e->getMessage());
                }

                return redirect()->route('saldo.payment', $transaksi->id)
                    ->with('success', 'Top-up request created successfully!');
            });

        } catch (\Exception $e) {
            Log::error('Saldo top-up failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat top-up. Silakan coba lagi.')
                        ->withInput();
        }
    }

    public function payment($id)
    {
        $transaksi = Transaksi::with(['items', 'metodePembayaran', 'user'])
            ->findOrFail($id);

        // Only show to transaction owner
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to transaction');
        }

        return view('portal.user.saldo.payment', compact('transaksi'));
    }

    public function success($id)
    {
        $transaksi = Transaksi::with(['items', 'metodePembayaran', 'user'])
            ->findOrFail($id);

        // Only show to transaction owner
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to transaction');
        }

        return view('portal.user.saldo.success', compact('transaksi'));
    }

    public function callback(Request $request)
    {
        try {
            // Midtrans callback handling
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed === $request->signature_key) {
                $orderId = $request->order_id;
                $transactionStatus = $request->transaction_status;
                $fraudStatus = $request->fraud_status ?? null;

                $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();

                if ($transaksi && str_starts_with($orderId, 'TOPUP-')) {
                    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                        // Payment successful - add to saldo
                        if (!$transaksi->paid_at) {
                            $saldo = $transaksi->user->saldo;
                            if ($saldo) {
                                $saldo->addBalance($transaksi->items->first()->price);
                            }
                            
                            $transaksi->update([
                                'paid_at' => now(),
                                'midtrans_status' => $transactionStatus,
                            ]);
                        }
                    } elseif ($transactionStatus == 'pending') {
                        $transaksi->update(['midtrans_status' => $transactionStatus]);
                    } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                        $transaksi->update(['midtrans_status' => $transactionStatus]);
                    }
                }
            }

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Saldo callback error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }
}
