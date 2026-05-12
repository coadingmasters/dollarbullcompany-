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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('whatsapp_number');
            $table->string('country');
            $table->enum('experience', ['less_than_6_months', 'more_than_6_months']);
            $table->enum('enrollment_type', ['online_lectures'])->default('online_lectures');
            $table->string('course')->default('Advanced Liquidity Bootcamp Batch 23');
            $table->string('payment_screenshot')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
