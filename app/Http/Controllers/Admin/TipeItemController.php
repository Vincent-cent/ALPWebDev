<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeItem;
use Illuminate\Http\Request;

class TipeItemController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_items,nama',
        ]);

        TipeItem::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Tipe Item berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $tipoItem = TipeItem::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_items,nama,' . $tipoItem->id,
        ]);

        $tipoItem->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Tipe Item berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tipoItem = TipeItem::findOrFail($id);
        $tipoItem->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Tipe Item berhasil dihapus');
    }
}
