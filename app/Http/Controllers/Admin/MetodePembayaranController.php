<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodePembayarans = MetodePembayaran::latest()->paginate(10);
        
        return view('portal.admin.metodepembayaran.admin-metode', compact('metodePembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $existingLogos = $this->getExistingLogos();
        
        return view('portal.admin.metodepembayaran.admin-add-metode', compact('existingLogos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans,name',
            'fee' => 'required|numeric|min:0',
            'type' => 'required|in:bank_transfer,qris,saldo,ewallet',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_logo' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $logoFileName = null;
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logoFileName = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('payment-methods', $logoFileName, 'public');
        } elseif ($request->filled('existing_logo')) {
            $logoFileName = $validated['existing_logo'];
        }

        MetodePembayaran::create([
            'name' => $validated['name'],
            'fee' => $validated['fee'],
            'type' => $validated['type'],
            'logo' => $logoFileName,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.metode-pembayarans.index')
                         ->with('success', 'Payment method created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MetodePembayaran $metodePembayaran)
    {
        return view('portal.admin.metodepembayaran.admin-show-metode', compact('metodePembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodePembayaran $metodePembayaran)
    {
        $existingLogos = $this->getExistingLogos();
        
        return view('portal.admin.metodepembayaran.admin-update-metode', compact('metodePembayaran', 'existingLogos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodePembayaran $metodePembayaran)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans,name,' . $metodePembayaran->id,
            'fee' => 'required|numeric|min:0',
            'type' => 'required|in:bank_transfer,qris,saldo,ewallet',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_logo' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $logoFileName = $metodePembayaran->logo;
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($metodePembayaran->logo) {
                Storage::disk('public')->delete('payment-methods/' . $metodePembayaran->logo);
            }
            
            $file = $request->file('logo');
            $logoFileName = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('payment-methods', $logoFileName, 'public');
        } elseif ($request->filled('existing_logo') && $validated['existing_logo'] !== $metodePembayaran->logo) {
            // Delete old logo if changing to existing one
            if ($metodePembayaran->logo) {
                Storage::disk('public')->delete('payment-methods/' . $metodePembayaran->logo);
            }
            $logoFileName = $validated['existing_logo'];
        }

        $metodePembayaran->update([
            'name' => $validated['name'],
            'fee' => $validated['fee'],
            'type' => $validated['type'],
            'logo' => $logoFileName,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.metode-pembayarans.index')
                         ->with('success', 'Payment method updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodePembayaran $metodePembayaran)
    {
        // Delete logo file if exists
        if ($metodePembayaran->logo) {
            Storage::disk('public')->delete('payment-methods/' . $metodePembayaran->logo);
        }
        
        $metodePembayaran->delete();

        return redirect()->route('admin.metode-pembayarans.index')
                         ->with('success', 'Payment method deleted successfully!');
    }

    /**
     * Get existing logos from storage
     */
    private function getExistingLogos()
    {
        $files = Storage::disk('public')->files('payment-methods');
        return collect($files)->map(function ($file) {
            return basename($file);
        })->filter(function ($file) {
            return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'svg']);
        })->values()->toArray();
    }
}
