<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'game_id',
        'tipe_item_id',
        'nama',
        'item_id',
        'tipe',
        'harga',
        'harga_coret',
        'discount_percent',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_items', 'item_id', 'game_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function tipeItem()
    {
        return $this->belongsTo(TipeItem::class);
    }
}