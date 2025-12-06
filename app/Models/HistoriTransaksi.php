<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'user_id',
        'note',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
