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
            ->whereNull('start_at') // No start date or start date has passed
            ->orWhere(function ($q) use ($request) {
                $q->where('code', $request->code)
                  ->where('kuota', '>', 0)
                  ->where('start_at', '<=', now());
            })
            ->whereNull('end_at') // No end date or end date hasn't passed
            ->orWhere(function ($q) use ($request) {
                $q->where('code', $request->code)
                  ->where('kuota', '>', 0)
                  ->where('end_at', '>=', now());
            })
            ->first();
        
        if (!$promo) {
            $promo = PromoCode::where('code', $request->code)
                ->where('kuota', '>', 0)
                ->first();
        }
        
        if ($promo && $promo->isValid()) {
            return response()->json([
                'valid' => true,
                'discount_percent' => $promo->discount_percent,
                'discount_amount' => $promo->discount_amount,
                'promo_id' => $promo->id
            ]);
        }
        
        return response()->json([
            'valid' => false,
            'message' => 'Kode promo tidak ditemukan atau sudah tidak berlaku'
        ]);
    }
}