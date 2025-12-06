<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $fillable = [
        'user_id',
        'user_game_uid',
        'nickname',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
