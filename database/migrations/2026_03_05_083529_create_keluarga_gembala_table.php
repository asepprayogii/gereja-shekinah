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
    Schema::create('keluarga_gembala', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 255);
        $table->string('peran', 100);
        $table->string('foto', 255)->nullable();
        $table->text('bio')->nullable();
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_gembala');
    }
};
