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
        Schema::create('web_links', function (Blueprint $table) {
            $table->uuid('web_links_id')->primary();
            $table->uuid('aplikasi_id');
            $table->string('nama_web', 64);
            $table->text('link');

            $table->foreign('aplikasi_id')->references('aplikasi_id')->on('aplikasi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_links');
    }
};
