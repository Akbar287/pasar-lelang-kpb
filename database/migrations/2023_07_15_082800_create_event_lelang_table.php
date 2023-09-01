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
        Schema::create('event_lelang', function (Blueprint $table) {
            $table->uuid('event_lelang_id')->primary();
            $table->uuid('status_event_lelang_id');
            $table->uuid('offline_profile_id');
            $table->string('event_kode', 32);
            $table->string('nama_lelang', 128);
            $table->date('tanggal_lelang');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->text('lokasi')->nullable();
            $table->string('ketua_lelang', 128);
            $table->timestamp('waktu_sinkronisasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status_pendaftaran', ['open', 'closed']);
            $table->boolean('is_open');
            $table->boolean('is_online');
            $table->timestamps();

            $table->foreign('offline_profile_id')->references('offline_profile_id')->on('offline_profile')->cascadeOnDelete();
            $table->foreign('status_event_lelang_id')->references('status_event_lelang_id')->on('status_event_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_lelang');
    }
};
