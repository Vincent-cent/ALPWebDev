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
