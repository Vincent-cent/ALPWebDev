<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMetodePembayaranController extends Controller
{
    /**
     * Display a listing of the payment methods.
     */
    public function index()
    {
        $metodePembayarans = MetodePembayaran::all();
        return view('portal.admin.metodepembayaran.admin-metodepembayaran', compact('metodePembayarans'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        return view('portal.admin.metodepembayaran.createmetodepembayaran');
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'type' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('payment_logos', 'public');
            $validated['logo'] = $logoPath;
        }

        MetodePembayaran::create($validated);

        return redirect()->route('admin.metodepembayaran.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit($id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);
        return view('portal.admin.metodepembayaran.updatemetodepembayaran', compact('metodePembayaran'));
    }

    /**
     * Update the specified payment method in storage.
     */
    public function update(Request $request, $id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'type' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($metodePembayaran->logo) {
                Storage::disk('public')->delete($metodePembayaran->logo);
            }
            $logoPath = $request->file('logo')->store('payment_logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $metodePembayaran->update($validated);

        return redirect()->route('admin.metodepembayaran.index')
            ->with('success', 'Metode pembayaran berhasil diupdate!');
    }

    /**
     * Show the form for confirming deletion.
     */
    public function delete($id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);
        return view('portal.admin.metodepembayaran.deletemetodepembayaran', compact('metodePembayaran'));
    }

    /**
     * Remove the specified payment method from storage.
     */
    public function destroy($id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);

        // Delete logo if exists
        if ($metodePembayaran->logo) {
            Storage::disk('public')->delete($metodePembayaran->logo);
        }

        $metodePembayaran->delete();

        return redirect()->route('admin.metodepembayaran.index')
            ->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}
