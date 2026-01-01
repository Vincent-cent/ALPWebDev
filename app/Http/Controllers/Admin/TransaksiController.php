<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'metodePembayaran', 'items.tipeItem', 'items.item']);
        
        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'paid') {
                $query->whereNotNull('paid_at');
            } elseif ($request->status === 'unpaid') {
                $query->whereNull('paid_at');
            } elseif ($request->status === 'cancelled') {
                $query->where('midtrans_status', 'cancelled');
            }
        }
        
        if ($request->filled('payment_method')) {
            $query->where('metode_pembayaran_id', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get filter options
        $users = User::select('id', 'name')->orderBy('name')->get();
        $metodePembayarans = MetodePembayaran::select('id', 'name')->orderBy('name')->get();
        
        // Calculate summary statistics
        $summary = [
            'total_paid' => Transaksi::whereNotNull('paid_at')->count(),
            'total_unpaid' => Transaksi::whereNull('paid_at')->count(),
            'total_today' => Transaksi::whereDate('created_at', today())->count(),
            'revenue' => Transaksi::whereNotNull('paid_at')->sum('total'),
            'avg_order_value' => Transaksi::whereNotNull('paid_at')->avg('total') ?? 0
        ];

        return view('portal.admin.transaksi.admin-transaksi', compact('transaksi', 'users', 'metodePembayarans', 'summary'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'metodePembayaran', 'transaksiItems.item.tipeItem', 'promoCode', 'game']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'metodePembayaran']);
        return view('portal.admin.transaksis.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:paid,unpaid,cancelled',
        ]);

        if ($request->status === 'paid' && !$transaksi->paid_at) {
            $transaksi->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);
        } else {
            $transaksi->update([
                'status' => $request->status
            ]);
        }

        return redirect()->route('admin.transaksi.index')
                        ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Only allow deletion of unpaid transactions
        if ($transaksi->paid_at) {
            return redirect()->route('admin.transaksi.index')
                           ->with('error', 'Cannot delete paid transactions.');
        }
        
        $transaksi->delete();
        
        return redirect()->route('admin.transaksi.index')
                        ->with('success', 'Transaction deleted successfully.');
    }
}
