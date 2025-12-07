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
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();

            //Reference to the main transaksi
            $table->foreignId('transaksi_id')
                ->constrained('transaksis')
                ->cascadeOnDelete();

            //Exact tipe_item purchased (diamonds pack, weekly pass, etc.)
            $table->foreignId('tipe_item_id')
                ->constrained('tipe_items')
                ->cascadeOnDelete();

            $table->integer('quantity')->default(1);

            //Price locked during purchase (after discount if any)
            $table->decimal('price', 14, 2);

            //Optional promo code applied
            $table->foreignId('promo_code_id')
                ->nullable()
                ->constrained('promo_codes')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
