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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'game_items', 'game_id', 'item_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function bannerPromos()
    {
        return $this->hasMany(BannerPromo::class);
    }
}