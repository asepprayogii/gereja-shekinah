<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'gembala', 'pelayan'])->default('pelayan')->after('email');
            $table->string('no_hp', 20)->nullable()->after('role');
            $table->string('foto', 255)->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp', 'foto']);
        });
    }
};
