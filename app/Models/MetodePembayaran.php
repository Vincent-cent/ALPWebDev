<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $fillable = [
        'name',
        'fee',
        'image',
        'logo',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
