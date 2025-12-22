<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\UserGame;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        protected $fillable = [
            'name',
            'email',
            'password',
            'role',
            'saldo_id',
        ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function saldo()
    {
        return $this->belongsTo(Saldo::class);
    }

    public function getSaldoAmount()
    {
        return $this->saldo ? $this->saldo->amount : 0;
    }

    public function getOrCreateSaldo()
    {
        if (!$this->saldo) {
            $saldo = Saldo::create(['amount' => 0]);
            $this->update(['saldo_id' => $saldo->id]);
            return $saldo;
        }
        return $this->saldo;
    }


    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class);
    }

}
