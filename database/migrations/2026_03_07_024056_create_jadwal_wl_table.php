<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_wl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->string('nama_wl', 255);
            $table->timestamps();
            
            // Index untuk performa
            $table->index('kegiatan_id');
            // 1 kegiatan = 1 WL (unique)
            $table->unique('kegiatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_wl');
    }
};