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
    Schema::create('kegiatan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kegiatan', 200);
        $table->string('jenis', 100);
        $table->date('tanggal');
        $table->time('jam_mulai');
        $table->time('jam_selesai')->nullable();
        $table->string('lokasi', 255)->nullable();
        $table->string('warna', 7)->default('#5b7fa6');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
