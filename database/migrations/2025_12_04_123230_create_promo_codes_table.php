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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();  // Example: MLBB10OFF
            $table->integer('kuota')->default(0); // How many times code can be used

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            // Optional: promo code may target a specific tipe_item
            $table->foreignId('tipe_item_id')
                ->nullable()
                ->constrained('tipe_items')
                ->nullOnDelete();

            // Option A: fixed discount amount
            $table->decimal('discount_amount', 14, 2)->nullable();

            // Option B: percentage discount
            $table->decimal('discount_percent', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
