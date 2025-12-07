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
        Schema::create('tipe_items', function (Blueprint $table) {
            $table->id();


            $table->foreignId('item_id')
                  ->constrained('items')
                  ->cascadeOnDelete();

            $table->string('name');                 // Example: "86 Diamonds", "Weekly Pass"
            $table->decimal('price', 12, 2);        // HargaTipeItem
            $table->integer('stock')->nullable();   // Nullable because digital items often unlimited
            $table->decimal('discount', 5, 2)->default(0); // in percent (0–100)
            $table->string('image')->nullable();    // icon for this tipe_item

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_items');
    }
};
