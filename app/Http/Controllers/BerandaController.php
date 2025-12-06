<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerPromo;
use App\Models\Game;
use App\Models\Item;
use App\Models\TipeItem;

class BerandaController extends Controller
{
  public function index()
    {
        $banners = BannerPromo::where('active', true)
            ->orderBy('id', 'desc')
            ->get();

        $popularGames = Game::with('items')
            ->take(6)
            ->get();

        $vouchers = Item::where('type', 'voucher')
            ->with('tipeItems')
            ->get();

        $games = Game::orderBy('name')->get();

        $recommended = TipeItem::orderBy('price')
            ->take(6)
            ->get();

        return view('beranda.index', compact(
            'banners',
            'popularGames',
            'vouchers',
            'games',
            'recommended'
        ));
    }
}
