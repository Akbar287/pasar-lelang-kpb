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
        Schema::create('carousel', function (Blueprint $table) {
            $table->uuid('carousel_id')->primary();
            $table->uuid('aplikasi_id');
            $table->text('image_src');
            $table->string('title', 64);
            $table->string('subtitle', 128);
            $table->integer('urutan');
            $table->string('page', 64);

            $table->foreign('aplikasi_id')->references('aplikasi_id')->on('aplikasi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousel');
    }
};
