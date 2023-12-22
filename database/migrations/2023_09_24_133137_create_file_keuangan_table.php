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
        Schema::create('file_keuangan', function (Blueprint $table) {
            $table->uuid('file_keuangan_id')->primary();
            $table->uuid('keuangan_id');
            $table->string('nama_file');
            $table->string('nama_dokumen');
            $table->date('tanggal_upload');

            $table->foreign('keuangan_id')->references('keuangan_id')->on('keuangan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_keuangan');
    }
};
