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
        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'game_id')) {
                $table->dropForeign(['game_id']);
                $table->dropColumn('game_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            if (!Schema::hasColumn('items', 'game_id')) {
                $table->unsignedBigInteger('game_id')->nullable();
                $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            }
        });
    }
};
