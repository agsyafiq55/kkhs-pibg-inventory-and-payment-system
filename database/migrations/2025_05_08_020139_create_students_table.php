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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->unsignedBigInteger('class_id');
            $table->string('name');
            $table->string('daftar_no')->nullable();
            $table->string('ic_no')->nullable();
            $table->string('form')->nullable();
            $table->string('stream')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('islam')->nullable();
            $table->string('previous_school')->nullable();
            $table->boolean('scholarship')->nullable();
            $table->timestamps();

            $table->foreign('class_id')->references('class_id')->on('classes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
