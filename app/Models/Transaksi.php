<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'transaksi_status_id',
        'metode_pembayaran_id',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_va_number',
        'midtrans_payment_type',
        'midtrans_status',
        'total',
        'paid_at',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(TransaksiStatus::class, 'transaksi_status_id');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function histories()
    {
        return $this->hasMany(HistoriTransaksi::class);
    }
}
