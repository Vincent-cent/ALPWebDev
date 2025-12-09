<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\MetodePembayaran;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class GameDetailController extends Controller
{
    public function show($id)
    {
        $game = Game::with(['items.tipeItem'])->findOrFail($id);
        $metodePembayaran = MetodePembayaran::all();
        
        return view('portal.user.game_detail', compact('game', 'metodePembayaran'));
    }
    
    public function verifyPromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        
        $promo = PromoCode::where('code', $request->code)
            ->where('kuota', '>', 0)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->first();
        
        if ($promo) {
            return response()->json([
                'valid' => true,
                'discount' => $promo->discount_percent,
                'max_discount' => $promo->discount_amount,
                'promo_id' => $promo->id
            ]);
        }
        
        return response()->json([
            'valid' => false,
            'message' => 'Kode promo tidak valid atau sudah kadaluarsa'
        ]);
    }
}