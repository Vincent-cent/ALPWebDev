<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeItem extends Model
{
    protected $fillable = [
        'item_id',
        'name',
        'price',
        'stock',
        'discount',
        'image',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class);
    }
}
