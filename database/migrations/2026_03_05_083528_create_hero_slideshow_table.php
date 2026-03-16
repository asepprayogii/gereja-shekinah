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
    Schema::create('hero_slideshow', function (Blueprint $table) {
        $table->id();
        $table->string('foto', 255);
        $table->string('judul', 255)->nullable();
        $table->string('deskripsi', 500)->nullable();
        $table->integer('urutan')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slideshow');
    }
};
