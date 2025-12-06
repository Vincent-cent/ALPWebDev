<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoNotifikasi extends Model
{
    protected $fillable = [
        'title',
        'description',
        'promo_code_id',
        'image',
    ];

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
}
