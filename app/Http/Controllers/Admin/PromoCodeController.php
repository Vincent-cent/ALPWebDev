<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\TipeItem;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::with('tipeItem')->paginate(10);
        return view('portal.admin.promocode.admin_promocode', compact('promoCodes'));
    }

    public function create()
    {
        $tipeItems = TipeItem::all();
        return view('portal.admin.promocode.admin-add-promocode', compact('tipeItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code|max:20',
            'kuota' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'tipe_item_id' => 'nullable|exists:tipe_items,id',
            'discount_type' => 'required|in:amount,percent',
            'discount_amount' => 'nullable|required_if:discount_type,amount|numeric|min:0',
            'discount_percent' => 'nullable|required_if:discount_type,percent|numeric|min:0|max:100',
        ]);

        $data = $request->only(['code', 'kuota', 'start_at', 'end_at', 'tipe_item_id']);
        
        if ($request->discount_type === 'amount') {
            $data['discount_amount'] = $request->discount_amount ?: null;
            $data['discount_percent'] = null;
        } else {
            $data['discount_percent'] = $request->discount_percent ?: null;
            $data['discount_amount'] = null;
        }

        PromoCode::create($data);

        return redirect()->route('admin.promo-codes.index')
                        ->with('success', 'Promo code created successfully.');
    }

    public function show(PromoCode $promoCode)
    {
        $promoCode->load('tipeItem');
        return view('portal.admin.promo-codes.show', compact('promoCode'));
    }

    public function edit(PromoCode $promoCode)
    {
        $tipeItems = TipeItem::all();
        return view('portal.admin.promocode.admin-update-promocode', compact('promoCode', 'tipeItems'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $promoCode->id . '|max:20',
            'kuota' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'tipe_item_id' => 'nullable|exists:tipe_items,id',
            'discount_type' => 'required|in:amount,percent',
            'discount_amount' => 'nullable|required_if:discount_type,amount|numeric|min:0',
            'discount_percent' => 'nullable|required_if:discount_type,percent|numeric|min:0|max:100',
        ]);

        $data = $request->only(['code', 'kuota', 'start_at', 'end_at', 'tipe_item_id']);
        
        if ($request->discount_type === 'amount') {
            $data['discount_amount'] = $request->discount_amount ?: null;
            $data['discount_percent'] = null;
        } else {
            $data['discount_percent'] = $request->discount_percent ?: null;
            $data['discount_amount'] = null;
        }

        $promoCode->update($data);

        return redirect()->route('admin.promo-codes.index')
                        ->with('success', 'Promo code updated successfully.');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')
                        ->with('success', 'Promo code deleted successfully.');
    }
}
