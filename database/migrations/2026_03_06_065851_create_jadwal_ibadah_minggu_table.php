<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_ibadah_minggu', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('posisi');
            $table->string('nama_pelayan');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_ibadah_minggu');
    }
};