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
            // Add game user credentials columns for APIGames integration
            $table->string('game_user_id')->nullable()->comment('In-game user ID for APIGames');
            $table->string('game_server_id')->nullable()->comment('In-game server ID for APIGames');
            $table->string('phone_number')->nullable()->comment('Phone number provided during checkout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['game_user_id', 'game_server_id', 'phone_number']);
        });
    }
};
