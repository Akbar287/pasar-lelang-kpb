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
        Schema::create('jenis_platform_lelang', function (Blueprint $table) {
            $table->uuid('jenis_platform_lelang_id')->primary();
            $table->uuid('lelang_id');
            $table->boolean('online')->nullable();
            $table->boolean('offline')->nullable();

            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_platform_lelang');
    }
};
