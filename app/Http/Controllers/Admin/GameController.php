<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('portal.admin.game.index', compact('games'));
    }

    public function create()
    {
        return view('portal.admin.game.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'tipe' => 'required|in:game,voucher',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('game'), $filename);
            $validated['image'] = 'game/' . $filename;
        }

        Game::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Game berhasil ditambahkan');
    }

    public function edit(Game $game)
    {
        return view('portal.admin.game.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'tipe' => 'required|in:game,voucher',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($game->image && file_exists(public_path($game->image))) {
                unlink(public_path($game->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('game'), $filename);
            $validated['image'] = 'game/' . $filename;
        }

        $game->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Game berhasil diperbarui');
    }

    public function destroy(Game $game)
    {
        // Delete image if exists
        if ($game->image && file_exists(public_path($game->image))) {
            unlink(public_path($game->image));
        }

        $game->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Game berhasil dihapus');
    }
}
