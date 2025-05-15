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
        // Add form and stream columns to classes table
        Schema::table('classes', function (Blueprint $table) {
            $table->string('form')->nullable()->after('class_name');
            $table->string('stream')->nullable()->after('form');
        });

        // Remove form and stream columns from students table
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['form', 'stream']);
        });

        // Create a new table for student class history
        Schema::create('student_class_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->year('academic_year');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')
                  ->onDelete('cascade');
            $table->foreign('class_id')->references('class_id')->on('classes')
                  ->onDelete('cascade');
            
            // A student can only be in one class per year
            $table->unique(['student_id', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the student class history table
        Schema::dropIfExists('student_class_history');
        
        // Add back form and stream columns to students table
        Schema::table('students', function (Blueprint $table) {
            $table->string('form')->nullable()->after('ic_no');
            $table->string('stream')->nullable()->after('form');
        });

        // Remove form and stream columns from classes table
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['form', 'stream']);
        });
    }
}; 