<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up() {
Schema::create('orders', function (Blueprint $table) {
$table->id();
$table->string('order_id')->unique();
$table->string('user_id_ml');
$table->string('server_id_ml');
$table->string('product_id');
$table->string('status')->default('pending');
$table->timestamps();
});
}


public function down() {
Schema::dropIfExists('orders');
}
};
