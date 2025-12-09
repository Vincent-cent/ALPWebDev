<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->foreignId('game_id')
                ->nullable()
                ->constrained('games')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_promos');
    }
};