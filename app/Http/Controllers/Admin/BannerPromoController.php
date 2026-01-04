<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPromo;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerPromoController extends Controller
{
    public function index()
    {
        $bannerPromos = BannerPromo::with('game')->paginate(10);
        return view('portal.admin.banner.admin-banner', compact('bannerPromos'));
    }

    public function create()
    {
        $games = Game::all();
        return view('portal.admin.banner.createbanner', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'game_id' => 'nullable|exists:games,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'game_id', 'order']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        BannerPromo::create($data);

        return redirect()->route('admin.banner-promos.index')
                        ->with('success', 'Banner promo created successfully.');
    }

    public function show(BannerPromo $bannerPromo)
    {
        $bannerPromo->load('game');
        return view('portal.admin.banner-promos.show', compact('bannerPromo'));
    }

    public function edit(BannerPromo $bannerPromo)
    {
        $games = Game::all();
        return view('portal.admin.banner.updatebanner', ['banner' => $bannerPromo, 'games' => $games]);
    }

    public function update(Request $request, BannerPromo $bannerPromo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'game_id' => 'nullable|exists:games,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'game_id', 'order']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($bannerPromo->image) {
                // Remove storage/ prefix for deletion
                $storagePath = str_replace('storage/', '', $bannerPromo->image);
                Storage::disk('public')->delete($storagePath);
            }
            
            $imagePath = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        $bannerPromo->update($data);

        return redirect()->route('admin.banner-promos.index')
                        ->with('success', 'Banner promo updated successfully.');
    }

    public function destroy(BannerPromo $bannerPromo)
    {
        // Delete associated image
        if ($bannerPromo->image) {
            Storage::disk('public')->delete($bannerPromo->image);
        }
        
        $bannerPromo->delete();
        
        return redirect()->route('admin.banner-promos.index')
                        ->with('success', 'Banner promo deleted successfully.');
    }

    private function getExistingBannerImages()
    {
        $bannersPath = storage_path('app/public/banners');
        
        if (!file_exists($bannersPath)) {
            return [];
        }

        $files = array_diff(scandir($bannersPath), array('.', '..'));
        $images = [];
        
        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                $images[] = 'banners/' . $file;
            }
        }
        
        return $images;
    }
}
