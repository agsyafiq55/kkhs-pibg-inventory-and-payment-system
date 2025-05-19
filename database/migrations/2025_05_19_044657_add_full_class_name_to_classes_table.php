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
        Schema::table('classes', function (Blueprint $table) {
            $table->string('full_class_name')->nullable()->after('class_name');
        });

        // Update existing records to fill the full_class_name field
        DB::statement('UPDATE classes SET full_class_name = CONCAT(form, " ", class_name) WHERE form IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('full_class_name');
        });
    }
};
