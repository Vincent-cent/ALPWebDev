<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoNotifikasi;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoNotifikasiController extends Controller
{
    public function index()
    {
        $promoNotifikasi = PromoNotifikasi::latest()->paginate(10);
        return view('portal.admin.notifikasi.admin-notifikasi', compact('promoNotifikasi'));
    }

    public function create()
    {
        $promoCodes = PromoCode::all();
        return view('portal.admin.promo-notifikasis.create', compact('promoCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'promo_code_id' => 'required|exists:promo_codes,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'promo_code_id']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notifications', 'public');
            $data['image'] = $imagePath;
        }

        PromoNotifikasi::create($data);

        return redirect()->route('admin.promo-notifikasis.index')
                        ->with('success', 'Promo notification created successfully.');
    }

    public function show(PromoNotifikasi $promoNotifikasi)
    {
        $promoNotifikasi->load('promoCode');
        return view('portal.admin.promo-notifikasis.show', compact('promoNotifikasi'));
    }

    public function edit(PromoNotifikasi $promoNotifikasi)
    {
        $promoCodes = PromoCode::all();
        return view('portal.admin.promo-notifikasis.edit', compact('promoNotifikasi', 'promoCodes'));
    }

    public function update(Request $request, PromoNotifikasi $promoNotifikasi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'promo_code_id' => 'required|exists:promo_codes,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'promo_code_id']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($promoNotifikasi->image) {
                Storage::disk('public')->delete($promoNotifikasi->image);
            }
            
            $imagePath = $request->file('image')->store('notifications', 'public');
            $data['image'] = $imagePath;
        }

        $promoNotifikasi->update($data);

        return redirect()->route('admin.promo-notifikasis.index')
                        ->with('success', 'Promo notification updated successfully.');
    }

    public function destroy(PromoNotifikasi $promoNotifikasi)
    {
        // Delete associated image
        if ($promoNotifikasi->image) {
            Storage::disk('public')->delete($promoNotifikasi->image);
        }
        
        $promoNotifikasi->delete();
        
        return redirect()->route('admin.promo-notifikasis.index')
                        ->with('success', 'Promo notification deleted successfully.');
    }
}
