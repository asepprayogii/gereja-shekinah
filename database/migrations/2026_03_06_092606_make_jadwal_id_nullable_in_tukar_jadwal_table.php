<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tukar_jadwal', function (Blueprint $table) {
            $table->foreignId('jadwal_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tukar_jadwal', function (Blueprint $table) {
            $table->foreignId('jadwal_id')->nullable(false)->change();
        });
    }
};