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
        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->uuid('blog_post_id');
            $table->uuid('blog_tag_id');

            $table->foreign('blog_post_id')->references('blog_post_id')->on('blog_post')->cascadeOnDelete();
            $table->foreign('blog_tag_id')->references('blog_tag_id')->on('blog_tag')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');
    }
};
