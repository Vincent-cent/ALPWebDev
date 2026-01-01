<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'kuota',
        'start_at',
        'end_at',
        'tipe_item_id',
        'discount_amount',
        'discount_percent',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];

    public function tipeItem()
    {
        return $this->belongsTo(TipeItem::class);
    }

    public function notifications()
    {
        return $this->hasMany(PromoNotifikasi::class);
    }
}
