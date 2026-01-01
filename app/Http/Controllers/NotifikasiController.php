<?php

namespace App\Http\Controllers;

use App\Models\PromoNotifikasi;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan halaman semua notifikasi
     */
    public function index(): View
    {
        $notifikasi = PromoNotifikasi::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifikasi.index', compact('notifikasi'));
    }

    /**
     * Menampilkan detail notifikasi
     */
    public function show(PromoNotifikasi $notifikasi): View
    {
        return view('notifikasi.show', compact('notifikasi'));
    }
}
