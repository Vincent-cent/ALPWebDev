<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoNotifikasi extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'promo_code_id',
        'image',
        'is_active',
        'priority',
        'type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
}
