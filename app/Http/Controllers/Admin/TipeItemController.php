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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/tipe-items'), $filename);
            $validated['image'] = 'images/tipe-items/' . $filename;
        }

        TipeItem::create($validated);

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $tipeItem = TipeItem::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tipe_items,name,' . $tipeItem->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($tipeItem->image && file_exists(public_path($tipeItem->image))) {
                unlink(public_path($tipeItem->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/tipe-items'), $filename);
            $validated['image'] = 'images/tipe-items/' . $filename;
        }

        $tipeItem->update($validated);

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tipeItem = TipeItem::findOrFail($id);
        
        // Delete image if exists
        if ($tipeItem->image && file_exists(public_path($tipeItem->image))) {
            unlink(public_path($tipeItem->image));
        }
        
        $tipeItem->delete();

        return redirect()->route('admin.games.index')->with('success', 'Tipe Item berhasil dihapus');
    }
}
