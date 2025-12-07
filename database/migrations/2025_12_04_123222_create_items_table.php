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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // 🔗 FK to game
            $table->foreignId('game_id')
                  ->constrained('games')
                  ->cascadeOnDelete();

            $table->string('name');                 // e.g., Diamonds, Subscription, Skin
            $table->string('type')->nullable();     // optional type classification
            $table->string('image')->nullable();    // card thumbnail

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
