<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPromo extends Model
{
    protected $fillable = [
        'name',
        'image',
        'active',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
