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
        Schema::create('promo_notifikasis', function (Blueprint $table) {
            $table->id();

            $table->string('title');        // e.g. "Limited Time Event!"
            $table->text('description')->nullable();

            // Optional — ties notification to a promo code
            $table->foreignId('promo_code_id')
                ->nullable()
                ->constrained('promo_codes')
                ->nullOnDelete();

            $table->string('image')->nullable();  // Banner image

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_notifikasis');
    }
};
