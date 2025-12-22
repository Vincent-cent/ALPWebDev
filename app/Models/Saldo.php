<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $fillable = [
        'amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function addBalance($amount)
    {
        $this->increment('amount', $amount);
        return $this;
    }

    public function deductBalance($amount)
    {
        if ($this->amount >= $amount) {
            $this->decrement('amount', $amount);
            return true;
        }
        return false;
    }

    public function hasEnoughBalance($amount)
    {
        return $this->amount >= $amount;
    }
}
