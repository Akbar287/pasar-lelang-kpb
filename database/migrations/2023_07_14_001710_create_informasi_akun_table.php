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
        Schema::create('informasi_akun', function (Blueprint $table) {
            $table->uuid('informasi_akun_id')->primary();
            $table->string('email', 128);
            $table->string('no_hp', 32);
            $table->string('no_wa', 32);
            $table->string('no_fax', 32);
            $table->string('avatar', 128);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_akun');
    }
};
