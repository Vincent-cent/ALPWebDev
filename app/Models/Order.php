<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Order extends Model {
protected $fillable = [
'order_id', 'user_id_ml', 'server_id_ml', 'product_id', 'status'
];
}