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
        Schema::create('deposito', function (Blueprint $table) {
            $table->uuid('deposito_id')->primary();
            $table->uuid('surat_berharga_id');
            $table->date('tanggal_terima');
            $table->string('no_sertifikat', 32);
            $table->string('no_rekening', 16);
            $table->date('tanggal_terbit');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_valuta');
            $table->string('bank_penerbit', 64);
            $table->decimal('nilai_nominal', 18, 2);
            $table->decimal('haircut', 18, 2);
            $table->decimal('nilai_tersedia', 18, 2);

            $table->foreign('surat_berharga_id')->references('surat_berharga_id')->on('surat_berharga')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposito');
    }
};
