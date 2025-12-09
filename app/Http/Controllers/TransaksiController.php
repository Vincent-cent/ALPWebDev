<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Item;
use App\Models\MetodePembayaran;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id' => 'required|string',
            'server_id' => 'nullable|string',
            'item_id' => 'required|exists:items,id',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'phone' => 'required|string',
            'promo_code' => 'nullable|string'
        ]);
        
        $item = Item::findOrFail($request->item_id);
        $metodePembayaran = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
        
        $subtotal = $item->harga;
        $adminFee = $metodePembayaran->fee;
        $discount = 0;
        $promoId = null;
        
        // Check promo code if provided
        if ($request->promo_code) {
            $promo = PromoCode::where('code', $request->promo_code)
                ->where('kuota', '>', 0)
                ->where('start_at', '<=', now())
                ->where('end_at', '>=', now())
                ->first();
            
            if ($promo) {
                $discount = min(
                    ($subtotal * $promo->discount_percent / 100),
                    $promo->discount_amount
                );
                $promoId = $promo->id;
                
                // Decrease promo quota
                $promo->decrement('kuota');
            }
        }
        
        $total = $subtotal + $adminFee - $discount;
        
        $transaksi = Transaksi::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'user_id' => auth(),
            'game_id' => $request->game_id,
            'item_id' => $request->item_id,
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'player_user_id' => $request->user_id,
            'player_server_id' => $request->server_id,
            'phone' => $request->phone,
            'promo_code_id' => $promoId,
            'subtotal' => $subtotal,
            'admin_fee' => $adminFee,
            'discount' => $discount,
            'total' => $total,
            'status' => 'pending'
        ]);
        
        return redirect()->route('transaksi.show', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat!');
    }
}