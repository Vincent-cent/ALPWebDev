<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\PromoCode;
use App\Models\BannerPromo;
use App\Models\Game;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'total_promo_codes' => PromoCode::count(),
            'total_banners' => BannerPromo::count(),
            'total_notifications' => 0, // Add when PromoNotifikasi model is available
            'total_transactions' => Transaksi::count()
        ];
        
        // Recent transactions with proper relationships
        $recent_transactions = Transaksi::with(['user', 'metodePembayaran'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get();

        return view('portal.admin.admin-dashboard', compact(
            'stats',
            'recent_transactions'
        ));
    }
}
