<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $fillable = [
        'amount'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
