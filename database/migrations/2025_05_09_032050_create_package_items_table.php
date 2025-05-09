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
        Schema::create('package_items', function (Blueprint $table) {
            $table->id('package_item_id');
            $table->foreignId('package_id')->constrained('packages', 'package_id')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('item_variants', 'variant_id')->onDelete('cascade');
            $table->boolean('for_muslim_only')->default(false);
            $table->boolean('for_non_muslim_only')->default(false);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_items');
    }
};
