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
        Schema::create('kurs_mata_uang', function (Blueprint $table) {
            $table->uuid('kurs_mata_uang_id')->primary();
            $table->string('kode_mata_uang_asal');
            $table->string('mata_uang_asal');
            $table->string('kode_mata_uang_tujuan');
            $table->string('mata_uang_tujuan');
            $table->date('tanggal_update');
            $table->string('url_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurs_mata_uang');
    }
};
