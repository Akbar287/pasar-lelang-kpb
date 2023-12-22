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
        Schema::create('rating_ulasan', function (Blueprint $table) {
            $table->uuid('rating_ulasan_id')->primary();
            $table->uuid('rating_detail_id');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('rating_detail_id')->references('rating_detail_id')->on('rating_detail')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_ulasan');
    }
};
