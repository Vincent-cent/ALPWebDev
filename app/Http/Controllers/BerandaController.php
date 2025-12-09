<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\BannerPromo;
use App\Models\Item;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $banners = BannerPromo::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        
        $popularGames = Game::with('items')
            ->where('tipe', 'game')
            ->take(12)
            ->get();
        
        $vouchers = Game::where('tipe', 'voucher')
            ->with('items')
            ->take(8)
            ->get();
        
        $allGames = Game::with('items')
            ->where('tipe', 'game')
            ->get();
        
        $recommended = Item::with('game')
            ->orderBy('harga', 'asc')
            ->take(12)
            ->get();
        
        return view('beranda', compact(
            'banners',
            'popularGames',
            'vouchers',
            'allGames',
            'recommended'
        ));
    }
}