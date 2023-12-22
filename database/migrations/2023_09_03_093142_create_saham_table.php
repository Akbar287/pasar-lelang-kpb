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
        Schema::create('saham', function (Blueprint $table) {
            $table->uuid('saham_id')->primary();
            $table->uuid('surat_berharga_id');
            $table->string('kode_saham', 128);
            $table->string('penerbit', 128);
            $table->decimal('harga_saham', 18, 2);
            $table->decimal('lot', 18, 2);
            $table->decimal('nilai_saham', 18, 2);
            $table->decimal('haircut', 18, 2);
            $table->decimal('nilai_tersedia', 18, 2);
            $table->text('lokasi')->nullable();

            $table->foreign('surat_berharga_id')->references('surat_berharga_id')->on('surat_berharga')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saham');
    }
};
