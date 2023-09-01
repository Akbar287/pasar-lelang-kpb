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
        Schema::create('ktp', function (Blueprint $table) {
            $table->uuid('ktp_id')->primary();
            $table->uuid('member_id');
            $table->string('nik', 16)->nullable();
            $table->string('nama', 64);
            $table->enum('jenis_kelamin', ['pria', 'wanita']);
            $table->string('tempat_lahir', 64)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->boolean('verified');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('member_id')->on('member')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ktp');
    }
};
