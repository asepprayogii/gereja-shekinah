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
    Schema::create('musik', function (Blueprint $table) {
        $table->id();
        $table->string('judul_lagu', 255);
        $table->string('penyanyi', 255)->nullable();
        $table->string('link_youtube', 500);
        $table->string('video_id', 50)->nullable();
        $table->string('thumbnail_url', 500)->nullable();
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musik');
    }
};
