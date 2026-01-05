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
        Schema::table('promo_notifikasis', function (Blueprint $table) {
            // Add missing columns with default values
            if (!Schema::hasColumn('promo_notifikasis', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            
            if (!Schema::hasColumn('promo_notifikasis', 'priority')) {
                $table->string('priority')->default('medium');
            }
            
            if (!Schema::hasColumn('promo_notifikasis', 'type')) {
                $table->string('type')->default('general');
            }
            
            if (!Schema::hasColumn('promo_notifikasis', 'content')) {
                $table->text('content')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_notifikasis', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'priority', 'type', 'content']);
        });
    }
};
