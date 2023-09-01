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
        Schema::create('status_lelang_pivot', function (Blueprint $table) {
            $table->uuid('status_lelang_pivot_id')->primary();
            $table->uuid('status_lelang_id');
            $table->uuid('lelang_id');
            $table->boolean('is_aktif');
            $table->timestamps();

            $table->foreign('status_lelang_id')->references('status_lelang_id')->on('status_lelang')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_lelang_pivot');
    }
};
