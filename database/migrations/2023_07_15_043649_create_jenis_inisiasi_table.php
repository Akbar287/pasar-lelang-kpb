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
        Schema::create('jenis_inisiasi', function (Blueprint $table) {
            $table->uuid('jenis_inisiasi_id')->primary();
            $table->string('nama_inisiasi', 128);
            $table->text('keterangan')->nullable();
            $table->boolean('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_inisiasi');
    }
};
