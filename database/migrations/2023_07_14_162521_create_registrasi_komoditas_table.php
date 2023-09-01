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
        Schema::create('registrasi_komoditas', function (Blueprint $table) {
            $table->uuid('registrasi_komoditas_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('jenis_registrasi_komoditas_id');
            $table->uuid('komoditas_id');
            $table->uuid('mutu_id');
            $table->uuid('gudang_id');
            $table->date('tanggal');
            $table->string('kode_transaksi', 32);
            $table->string('no_instruksi', 32);
            $table->decimal('quantity', 18, 2);
            $table->decimal('nilai', 18, 2);
            $table->string('no_bast', 32);
            $table->date('kadaluarsa');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('komoditas_id')->references('komoditas_id')->on('komoditas')->cascadeOnDelete();
            $table->foreign('mutu_id')->references('mutu_id')->on('mutu')->cascadeOnDelete();
            $table->foreign('jenis_registrasi_komoditas_id')->references('jenis_registrasi_komoditas_id')->on('jenis_registrasi_komoditas')->cascadeOnDelete();
            $table->foreign('gudang_id')->references('gudang_id')->on('gudang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_komoditas');
    }
};
