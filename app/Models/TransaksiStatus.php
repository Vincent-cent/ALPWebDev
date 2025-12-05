<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiStatus extends Model
{
    protected $casts = [
        'name' => TransaksiStatusEnum::class,
    ];
}
