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
    Schema::create('about_gereja', function (Blueprint $table) {
        $table->id();
        $table->string('nama_gereja', 255)->default('GPdI Shekinah');
        $table->text('sejarah')->nullable();
        $table->text('visi')->nullable();
        $table->text('misi')->nullable();
        $table->string('instagram', 255)->nullable();
        $table->string('youtube', 255)->nullable();
        $table->string('facebook', 255)->nullable();
        $table->string('tiktok', 255)->nullable();
        $table->text('alamat')->nullable();
        $table->text('maps_embed')->nullable();
        $table->string('no_telp', 20)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_gereja');
    }
};
