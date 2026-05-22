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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');          // URL or storage path
            $table->string('badge')->nullable();
            $table->string('headline')->nullable();
            $table->string('highlight')->nullable();
            $table->text('sub')->nullable();
            $table->string('btn1_label')->nullable();
            $table->string('btn1_url')->nullable();
            $table->string('btn2_label')->nullable();
            $table->string('btn2_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
