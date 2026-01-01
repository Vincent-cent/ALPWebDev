<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPromo;
use App\Models\Game;
use App\Models\Item;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function dashboard()
    {
        $banners = BannerPromo::all();
        $games = Game::all();
        $items = Item::all();
        return view('portal.admin.admin-dashboard', compact('banners', 'games', 'items'));
    }

    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        $games = Game::all();
        return view('portal.admin.banner.createbanner', compact('games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:1',
            'game_id' => 'nullable|exists:games,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('banner'), $filename);
            $validated['image'] = 'banner/' . $filename;
        }

        BannerPromo::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit(BannerPromo $banner)
    {
        $games = Game::all();
        return view('portal.admin.banner.updatebanner', compact('banner', 'games'));
    }

    public function update(Request $request, BannerPromo $banner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:1',
            'game_id' => 'nullable|exists:games,id',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('banner'), $filename);
            $validated['image'] = 'banner/' . $filename;
        }

        $banner->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Banner berhasil diperbarui');
    }

    public function destroy(BannerPromo $banner)
    {
        // Delete image if exists
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $banner->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Banner berhasil dihapus');
    }
}
