<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans',
            'fee' => 'required|numeric|min:0',
            'type' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        MetodePembayaran::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Metode Pembayaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans,name,' . $metodePembayaran->id,
            'fee' => 'required|numeric|min:0',
            'type' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $metodePembayaran->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Metode Pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $metodePembayaran = MetodePembayaran::findOrFail($id);
        $metodePembayaran->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Metode Pembayaran berhasil dihapus');
    }
}
