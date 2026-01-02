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
            'name' => 'required|string|max:255|unique:tipe_items,name',
            'description' => 'nullable|string',
        ]);

        TipeItem::create($validated);

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $tipeItem = TipeItem::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tipe_items,name,' . $tipeItem->id,
            'description' => 'nullable|string',
        ]);

        $tipeItem->update($validated);

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tipeItem = TipeItem::findOrFail($id);
        $tipeItem->delete();

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil dihapus');
    }
}
