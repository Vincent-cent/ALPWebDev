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
        Schema::table('transaksi_items', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['tipe_item_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('tipe_item_id')->nullable()->change();
            
            // Re-add the foreign key constraint with nullable
            $table->foreign('tipe_item_id')
                ->references('id')
                ->on('tipe_items')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_items', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['tipe_item_id']);
            
            // Set any NULL values to 0 before making not nullable
            // This ensures we can safely revert to NOT NULL
        });
        
        // Update any NULL tipe_item_id values to 0
        DB::table('transaksi_items')->whereNull('tipe_item_id')->update(['tipe_item_id' => 0]);
        
        Schema::table('transaksi_items', function (Blueprint $table) {
            // Make the column not nullable again
            $table->unsignedBigInteger('tipe_item_id')->nullable(false)->change();
            
            // Re-add the foreign key constraint
            $table->foreign('tipe_item_id')
                ->references('id')
                ->on('tipe_items')
                ->cascadeOnDelete();
        });
    }
};
