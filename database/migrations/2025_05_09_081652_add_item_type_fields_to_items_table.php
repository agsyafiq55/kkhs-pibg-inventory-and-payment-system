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
            $table->enum('item_type', ['Book', 'School Supply'])->default('School Supply')->after('name');
            $table->unsignedBigInteger('subject_id')->nullable()->after('category_id');
            $table->unsignedBigInteger('stream_id')->nullable()->after('subject_id');
            $table->string('form')->nullable()->after('stream_id');
            
            // Add foreign keys for the new relationships
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('set null');
            $table->foreign('stream_id')->references('stream_id')->on('streams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['stream_id']);
            $table->dropColumn(['item_type', 'subject_id', 'stream_id', 'form']);
        });
    }
};
