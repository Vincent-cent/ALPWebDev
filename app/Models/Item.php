<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'game_id',
        'name',
        'type',
        'image',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function tipeItems()
    {
        return $this->hasMany(TipeItem::class);
    }
}
