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
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['experience', 'enrollment_type']);
            
            // Add new columns
            $table->string('cicni')->nullable()->after('country');
            $table->string('face_recognition')->nullable()->after('cicni');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['cicni', 'face_recognition']);
            
            $table->enum('experience', ['less_than_6_months', 'more_than_6_months'])->after('country');
            $table->enum('enrollment_type', ['online_lectures'])->default('online_lectures')->after('experience');
        });
    }
};
