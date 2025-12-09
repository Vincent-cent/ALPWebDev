<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'game_id',
        'tipe_item_id',
        'nama',
        'harga',
        'harga_coret',
        'discount_percent',
        'image',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function tipeItem()
    {
        return $this->belongsTo(TipeItem::class);
    }
}