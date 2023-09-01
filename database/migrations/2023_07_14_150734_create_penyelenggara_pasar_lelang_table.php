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
        Schema::create('penyelenggara_pasar_lelang', function (Blueprint $table) {
            $table->uuid('penyelenggara_pasar_lelang_id')->primary();
            $table->uuid('admin_id');

            $table->foreign('admin_id')->references('admin_id')->on('admin')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyelenggara_pasar_lelang');
    }
};
