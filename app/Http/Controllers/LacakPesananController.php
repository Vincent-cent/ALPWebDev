<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LacakPesananController extends Controller
{
    public function index()
    {
        return view('lacak-pesanan');
    }

    public function track(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|string|max:255'
        ]);

        $invoiceId = trim($request->invoice_id);
        
        // Search for transaction by midtrans_order_id or ID
        $transaksi = Transaksi::where('midtrans_order_id', $invoiceId)
                             ->orWhere('id', $invoiceId)
                             ->first();

        if (!$transaksi) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Invoice id tidak valid.');
        }

        // For guest users, only allow them to access guest transactions (user_id is null)
        // and add the transaction to their session so they can view it
        if (!auth()->check()) {
            // Only allow guests to view transactions that were created by guests
            if ($transaksi->user_id !== null) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'You are not authorized to view this transaction. Please log in if this is your account.');
            }
            
            $guestTransactions = session('guest_transactions', []);
            if (!in_array($transaksi->id, $guestTransactions)) {
                $guestTransactions[] = $transaksi->id;
                session(['guest_transactions' => $guestTransactions]);
            }
        } else {
            // For authenticated users, check if the transaction belongs to them
            if ($transaksi->user_id && $transaksi->user_id !== auth()->id()) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'You are not authorized to view this transaction.');
            }
        }

        // Redirect to transaction page
        return redirect()->route('transaksi.show', $transaksi->id);
    }
}
