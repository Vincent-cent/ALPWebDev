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
        Schema::create('histori_transaksis', function (Blueprint $table) {
            $table->id();

            // 🔗 Reference to transaksi
            $table->foreignId('transaksi_id')
                ->nullable()
                ->constrained('transaksis')
                ->nullOnDelete();

            // 🔗 The user who performed the action (admin or user)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Notes such as "Payment confirmed", "Waiting for admin"
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_transaksis');
    }
};
