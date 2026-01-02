<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Item;
use App\Models\TipeItem;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['items.tipeItem'])->get();
        $tipeItems = TipeItem::all();
        return view('portal.admin.game.admin-game', compact('games', 'tipeItems'));
    }

    public function create()
    {
        $items = Item::with('tipeItem')->get();
        return view('portal.admin.game.admin-add-game', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        Game::create($validated);

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil ditambahkan');
    }

    public function edit(Game $game)
    {
        $items = Item::with('tipeItem')->get();
        $game->load('items');
        return view('portal.admin.game.admin-edit-game', compact('game', 'items'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $game->is_active;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($game->image) {
                \Storage::disk('public')->delete($game->image);
            }
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        $game->update($validated);

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil diperbarui');
    }

    public function destroy(Game $game)
    {
        // Delete image if exists
        if ($game->image) {
            \Storage::disk('public')->delete($game->image);
        }

        // Detach items
        $game->items()->detach();

        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil dihapus');
    }

    public function addItem(Request $request, Game $game)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe_item_id' => 'required|exists:tipe_items,id',
            'harga' => 'required|numeric|min:0',
            'harga_coret' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'item_id' => 'nullable|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        // Create new item
        $item = Item::create($validated);

        // Attach to game
        $game->items()->attach($item->id, ['quantity' => 1]);

        return redirect()->route('admin.games.index')->with('success', 'Item berhasil ditambah ke game');
    }

    public function updateItemQuantity(Request $request, Game $game, Item $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $game->items()->updateExistingPivot($item->id, ['quantity' => $validated['quantity']]);

        return redirect()->route('admin.games.index')->with('success', 'Quantity berhasil diupdate');
    }

    public function removeItem(Game $game, Item $item)
    {
        $game->items()->detach($item->id);

        return redirect()->route('admin.games.index')->with('success', 'Item removed from game successfully');
    }
}