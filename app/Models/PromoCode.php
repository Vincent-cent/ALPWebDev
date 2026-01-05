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

    /**
     * Check if promo code is valid based on dates and quota
     */
    public function isValid()
    {
        // Check quota
        if ($this->kuota <= 0) {
            return false;
        }

        // Check start date
        if ($this->start_at && $this->start_at > now()) {
            return false;
        }

        // Check end date
        if ($this->end_at && $this->end_at < now()) {
            return false;
        }

        return true;
    }
}
