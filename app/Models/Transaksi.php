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
        'apigames_order_id',
        'apigames_status',
        'apigames_response',
        'total',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'total' => 'decimal:2',
        'apigames_response' => 'array',
    ];

    // Accessor for legacy total_harga field name
    public function getTotalHargaAttribute()
    {
        return $this->total;
    }

    // Accessor for order_id
    public function getOrderIdAttribute()
    {
        return $this->midtrans_order_id ?? 'TRX-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Status accessor
    public function getStatusAttribute()
    {
        if ($this->paid_at) {
            return 'paid';
        } elseif ($this->midtrans_status === 'cancelled') {
            return 'cancelled';
        } else {
            return 'unpaid';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest User',
            'email' => 'guest@example.com'
        ]);
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
