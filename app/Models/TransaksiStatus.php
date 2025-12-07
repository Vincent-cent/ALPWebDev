<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TransaksiStatusEnum;

class TransaksiStatus extends Model
{
    protected $fillable = ['name'];

    protected $casts = [
        'name' => TransaksiStatusEnum::class,
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
