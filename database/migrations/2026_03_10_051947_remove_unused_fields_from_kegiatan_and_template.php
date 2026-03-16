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
        // Hapus kolom jam_selesai dan warna dari tabel kegiatan
        Schema::table('kegiatan', function (Blueprint $table) {
            // Cek dulu apakah kolom ada sebelum dihapus (agar aman)
            if (Schema::hasColumn('kegiatan', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
            if (Schema::hasColumn('kegiatan', 'warna')) {
                $table->dropColumn('warna');
            }
        });
        
        // Hapus kolom jam_selesai dan warna dari tabel jadwal_template
        Schema::table('jadwal_template', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_template', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
            if (Schema::hasColumn('jadwal_template', 'warna')) {
                $table->dropColumn('warna');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom jika migration di-rollback (opsional)
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->time('jam_selesai')->nullable();
            $table->string('warna')->default('#5b7fa6');
        });
        
        Schema::table('jadwal_template', function (Blueprint $table) {
            $table->time('jam_selesai')->nullable();
            $table->string('warna')->default('#5b7fa6');
        });
    }
};