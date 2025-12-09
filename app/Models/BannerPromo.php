<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPromo extends Model
{
    protected $fillable = [
        'name',
        'image',
        'is_active',
        'order',
        'game_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
