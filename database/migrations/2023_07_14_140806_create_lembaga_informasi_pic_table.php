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
        Schema::create('lembaga_informasi_pic', function (Blueprint $table) {
            $table->uuid('lembaga_informasi_pic_id')->primary();
            $table->uuid('lembaga_id');
            $table->uuid('member_id');
            $table->string('jabatan', 64);
            $table->boolean('is_aktif');

            $table->foreign('lembaga_id')->references('lembaga_id')->on('lembaga')->cascadeOnDelete();
            $table->foreign('member_id')->references('member_id')->on('member')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga_informasi_pic');
    }
};
