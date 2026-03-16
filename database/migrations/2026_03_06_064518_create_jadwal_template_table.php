<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_template', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('jenis')->default('Ibadah');
            $table->tinyInteger('hari'); // 0=Minggu, 1=Senin, dst
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('warna')->default('#5b7fa6');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_template');
    }
};