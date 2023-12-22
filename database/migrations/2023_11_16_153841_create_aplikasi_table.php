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
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->uuid('aplikasi_id')->primary();
            $table->string('nama_aplikasi', 64);
            $table->text('header_description');
            $table->text('footer_description');
            $table->text('img_welcome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplikasi');
    }
};
