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
        Schema::create('member_kpb', function (Blueprint $table) {
            $table->uuid('member_kpb_id')->primary();
            $table->string('nik', 20);
            $table->string('nama', 50);
            $table->text('alamat')->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp', 16)->nullable();
            $table->string('no_wa', 16)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password')->nullable();
            $table->integer('kode_pos', 20)->nullable();
            $table->varchar('provinsi_id', 20)->nullable();
            $table->varchar('kabupaten_id', 20)->nullable();
            $table->varchar('kecamatan_id', 20)->nullable();
            $table->varchar('desa_id', 20)->nullable();
            $table->boolean('confirmed')->nullable();
            $table->boolean('verified')->nullable();
            $table->string('status', 16)->nullable();
            $table->boolean('is_member_lelang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_kpb');
    }
};
