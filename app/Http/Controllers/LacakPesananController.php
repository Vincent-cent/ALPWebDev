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

        // Redirect to transaction page
        return redirect()->route('transaksi.show', $transaksi->id);
    }
}
