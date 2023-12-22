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
        Schema::create('rating_detail', function (Blueprint $table) {
            $table->uuid('rating_detail_id')->primary();
            $table->uuid('rating_id');
            $table->uuid('lelang_id');
            $table->uuid('informasi_akun_id');
            $table->integer('star');
            $table->boolean('secret');
            $table->timestamps();

            $table->foreign('rating_id')->references('rating_id')->on('rating')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_detail');
    }
};
