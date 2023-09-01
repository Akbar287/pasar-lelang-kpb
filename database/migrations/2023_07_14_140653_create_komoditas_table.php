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
        Schema::create('komoditas', function (Blueprint $table) {
            $table->uuid('komoditas_id')->primary();
            $table->uuid('jenis_komoditas_id');
            $table->string('nama_komoditas', 128);
            $table->string('satuan_ukuran', 16);
            $table->boolean('inisiasi');
            $table->boolean('kadaluarsa');

            $table->foreign('jenis_komoditas_id')->references('jenis_komoditas_id')->on('jenis_komoditas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditas');
    }
};
