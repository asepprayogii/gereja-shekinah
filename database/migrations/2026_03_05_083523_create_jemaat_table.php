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
    Schema::create('jemaat', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->string('no_hp', 20)->nullable();
        $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah', 'Janda/Duda'])->nullable();
        $table->string('pekerjaan', 150)->nullable();
        $table->date('tanggal_baptis')->nullable();
        $table->date('tanggal_sidi')->nullable();
        $table->text('nama_keluarga')->nullable();
        $table->string('foto', 255)->nullable();
        $table->boolean('status_aktif')->default(true);
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jemaat');
    }
};
