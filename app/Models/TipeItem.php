<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class);
    }
}
