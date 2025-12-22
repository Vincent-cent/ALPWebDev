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

            $table->string('code')->unique();  
            $table->integer('kuota')->default(0); 

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            
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
