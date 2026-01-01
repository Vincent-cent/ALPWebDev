<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $fillable = [
        'transaksi_id',
        'item_id',
        'tipe_item_id',
        'quantity',
        'price',
        'promo_code_id'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function tipeItem()
    {
        return $this->belongsTo(TipeItem::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
}
