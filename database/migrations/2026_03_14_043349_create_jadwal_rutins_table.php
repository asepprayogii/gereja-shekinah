<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_rutin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hari'); // Senin, Selasa, etc
            $table->integer('hari_urutan'); // 1-7 untuk sorting
            $table->string('nama_kegiatan');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('hari_urutan');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_rutin');
    }
};