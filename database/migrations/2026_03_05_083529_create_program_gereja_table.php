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
    Schema::create('program_gereja', function (Blueprint $table) {
        $table->id();
        $table->string('nama_program', 255);
        $table->text('deskripsi')->nullable();
        $table->string('foto', 255)->nullable();
        $table->string('link_info', 500)->nullable();
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
        Schema::dropIfExists('program_gereja');
    }
};
