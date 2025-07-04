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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->foreignId('package_id')->constrained('packages', 'package_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('stripe');
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->default('pending'); // pending, completed, failed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
