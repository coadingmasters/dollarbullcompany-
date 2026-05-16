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
        Schema::table('live_session_enrollments', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('approved_at');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('email')->nullable()->after('last_name');
            $table->string('whatsapp_number')->nullable()->after('email');
            $table->string('country')->nullable()->after('whatsapp_number');
            $table->string('cicni')->nullable()->after('country');
            $table->string('face_photo')->nullable()->after('cicni');
            $table->string('payment_screenshot')->nullable()->after('face_photo');
        });
    }

    public function down(): void
    {
        Schema::table('live_session_enrollments', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'email', 'whatsapp_number', 'country', 'cicni', 'face_photo', 'payment_screenshot']);
        });
    }
};
