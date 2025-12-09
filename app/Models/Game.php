<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'tipe',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function bannerPromos()
    {
        return $this->hasMany(BannerPromo::class);
    }
}