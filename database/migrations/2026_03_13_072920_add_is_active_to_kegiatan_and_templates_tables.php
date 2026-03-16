<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan is_active ke tabel kegiatan
        if (Schema::hasTable('kegiatan') && !Schema::hasColumn('kegiatan', 'is_active')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('keterangan');
                $table->index('is_active');
            });
        }

        // Tambahkan is_active ke tabel jadwal_template
        if (Schema::hasTable('jadwal_template') && !Schema::hasColumn('jadwal_template', 'is_active')) {
            Schema::table('jadwal_template', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('warna');
                $table->index('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kegiatan', 'is_active')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('jadwal_template') && Schema::hasColumn('jadwal_template', 'is_active')) {
            Schema::table('jadwal_template', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
                $table->dropColumn('is_active');
            });
        }
    }
};