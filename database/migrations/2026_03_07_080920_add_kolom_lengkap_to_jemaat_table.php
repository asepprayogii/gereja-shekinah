<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jemaat', function (Blueprint $table) {
            // Tambah kalau belum ada
            if (!Schema::hasColumn('jemaat', 'no_kaj')) {
                $table->string('no_kaj')->nullable()->after('id');
            }
            if (!Schema::hasColumn('jemaat', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('jemaat', 'baptisan_air')) {
                $table->boolean('baptisan_air')->default(false)->after('tempat_lahir');
            }
            if (!Schema::hasColumn('jemaat', 'status_keluarga')) {
                // Bp / Ibu / Sdr / Sdri / Anak
                $table->string('status_keluarga')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('jemaat', 'nama_kepala_keluarga')) {
                $table->string('nama_kepala_keluarga')->nullable()->after('status_keluarga');
            }
            if (!Schema::hasColumn('jemaat', 'penyerahan_anak')) {
                $table->boolean('penyerahan_anak')->default(false)->after('baptisan_air');
            }
            if (!Schema::hasColumn('jemaat', 'berkas_pdf')) {
                $table->string('berkas_pdf')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jemaat', function (Blueprint $table) {
            $table->dropColumn([
                'no_kaj', 'tempat_lahir', 'baptisan_air',
                'status_keluarga', 'nama_kepala_keluarga',
                'penyerahan_anak', 'berkas_pdf',
            ]);
        });
    }
};