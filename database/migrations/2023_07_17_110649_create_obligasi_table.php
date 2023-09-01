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
        Schema::create('obligasi', function (Blueprint $table) {
            $table->uuid('obligasi_id')->primary();
            $table->uuid('surat_berharga_id');
            $table->string('jenis', 64);
            $table->string('penerbit', 128);
            $table->string('nilai_nominal', 18, 2);
            $table->string('kupon', 128);
            $table->string('tipe_kupon', 128);
            $table->decimal('haircut', 18, 2);
            $table->decimal('nilai_tersedia', 18, 2);
            $table->date('tanggal_penerbitan');
            $table->date('tanggal_jatuh_tempo');
            $table->string('lokasi', 128);

            $table->foreign('surat_berharga_id')->references('surat_berharga_id')->on('surat_berharga')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obligasi');
    }
};
