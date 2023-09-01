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
        Schema::create('status_event_lelang', function (Blueprint $table) {
            $table->uuid('status_event_lelang_id')->primary();
            $table->string('nama_status', 128);
            $table->string('icon', 128);
            $table->smallInteger('urutan');
            $table->text('keterangan')->nullable();
            $table->boolean('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_event_lelang');
    }
};
