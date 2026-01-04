<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Game;
use App\Models\TipeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('portal.admin.item.index', compact('items'));
    }

    public function create()
    {
        $games = Game::all();
        $tipoItems = TipeItem::all();
        return view('portal.admin.item.create', compact('games', 'tipoItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'item_id' => 'nullable|string|max:50',
            'game_id' => 'required|exists:games,id',
            'harga' => 'required|numeric|min:0',
            'tipe_item_id' => 'nullable|exists:tipe_items,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('item'), $filename);
            $validated['image'] = 'item/' . $filename;
        }

        Item::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(Item $item)
    {
        $games = Game::all();
        $tipoItems = TipeItem::all();
        return view('portal.admin.item.edit', compact('item', 'games', 'tipoItems'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'item_id' => 'nullable|string|max:255',
            'tipe_item_id' => 'required|exists:tipe_items,id',
            'harga' => 'required|numeric|min:0',
            'harga_coret' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'tipe' => 'nullable|string|max:255',
        ]);

        $item->update($validated);
        return redirect()->route('admin.games.index')->with('success', 'Item berhasil diupdate');
    }

    public function destroy(Item $item)
    {

        $item->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Item berhasil dihapus');
    }
}
