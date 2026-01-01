<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('apigames_order_id')->nullable()->after('midtrans_status');
            $table->string('apigames_status')->nullable()->after('apigames_order_id');
            $table->json('apigames_response')->nullable()->after('apigames_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['apigames_order_id', 'apigames_status', 'apigames_response']);
        });
    }
};
