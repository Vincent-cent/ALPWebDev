<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $fillable = [
        'name',
        'fee',
        'type',
        'logo',
        'is_active',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
