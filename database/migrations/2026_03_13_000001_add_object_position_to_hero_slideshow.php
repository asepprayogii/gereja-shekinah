<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slideshow', function (Blueprint $table) {
            $table->string('object_position', 50)->default('center')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('hero_slideshow', function (Blueprint $table) {
            $table->dropColumn('object_position');
        });
    }
};