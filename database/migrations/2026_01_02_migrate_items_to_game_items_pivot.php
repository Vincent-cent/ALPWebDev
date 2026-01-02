<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing items with game_id to game_items pivot table
        $items = DB::table('items')->whereNotNull('game_id')->get();
        
        foreach ($items as $item) {
            DB::table('game_items')->updateOrInsert(
                [
                    'game_id' => $item->game_id,
                    'item_id' => $item->id,
                ],
                [
                    'quantity' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete all game_items created by this migration
        DB::table('game_items')->truncate();
    }
};
