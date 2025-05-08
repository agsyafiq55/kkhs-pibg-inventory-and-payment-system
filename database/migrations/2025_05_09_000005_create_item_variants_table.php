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
        Schema::create('item_variants', function (Blueprint $table) {
            $table->id('variant_id');
            $table->unsignedBigInteger('items_id');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('barcode')->unique();
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('items_id')->references('items_id')->on('items')->onDelete('cascade');
            $table->foreign('color_id')->references('color_id')->on('colors')->onDelete('set null');
            $table->foreign('size_id')->references('size_id')->on('sizes')->onDelete('set null');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_variants');
    }
}; 