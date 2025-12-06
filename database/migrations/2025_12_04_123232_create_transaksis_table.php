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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            //  The user who created the transaction (can be null if guest flow allowed)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            //  Payment status (pending, paid, failed, etc.)
            $table->foreignId('transaksi_status_id')
                ->nullable()
                ->constrained('transaksi_statuses')
                ->nullOnDelete();

            //  Payment method (bank, QRIS, etc.)
            $table->foreignId('metode_pembayaran_id')
                ->nullable()
                ->constrained('metode_pembayarans')
                ->nullOnDelete();

            //  Midtrans integration fields (for later)
            $table->string('midtrans_order_id')->nullable();  // order_id for Midtrans
            $table->string('midtrans_transaction_id')->nullable(); // transaction_id
            $table->string('midtrans_va_number')->nullable();   // VA number if bank transfer
            $table->string('midtrans_payment_type')->nullable(); // bank_transfer, qris, gopay, etc.
            $table->string('midtrans_status')->nullable();       // pending, settlement, etc.

            $table->decimal('total', 14, 2)->default(0);

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
