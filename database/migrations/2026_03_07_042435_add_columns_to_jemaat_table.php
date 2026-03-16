<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jemaat', function (Blueprint $table) {
            $table->string('no_kaj')->nullable()->after('id');
            $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            $table->enum('status_keluarga', [
                'Kepala Keluarga', 'Istri', 'Anak', 'Saudara'
            ])->default('Kepala Keluarga')->after('jenis_kelamin');
            $table->string('nama_pasangan')->nullable()->after('status_keluarga');
            $table->boolean('baptisan_air')->default(false)->after('nama_pasangan');
            $table->boolean('penyerahan_anak')->default(false)->after('baptisan_air');
            $table->string('berkas_pdf')->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('jemaat', function (Blueprint $table) {
            $table->dropColumn([
                'no_kaj', 'tempat_lahir', 'status_keluarga',
                'nama_pasangan', 'baptisan_air', 'penyerahan_anak', 'berkas_pdf'
            ]);
        });
    }
};