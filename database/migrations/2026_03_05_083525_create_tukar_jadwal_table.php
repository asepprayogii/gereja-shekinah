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
    Schema::create('tukar_jadwal', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jadwal_id')->constrained('jadwal_pelayanan')->onDelete('cascade');
        $table->foreignId('pemohon_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('pengganti_id')->nullable()->constrained('users')->onDelete('set null');
        $table->text('alasan');
        $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
        $table->text('catatan_admin')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tukar_jadwal');
    }
};
