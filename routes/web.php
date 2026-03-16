<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Gembala\DashboardController as GembalaDashboard;
use App\Http\Controllers\Pelayan\DashboardController as PelayanDashboard;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [PublikController::class, 'beranda'])->name('beranda');
Route::get('/renungan', [PublikController::class, 'renungan'])->name('renungan');
Route::get('/renungan/{id}', [PublikController::class, 'renunganDetail'])->name('renungan.detail');

Route::get('/jadwal-ibadah', [PublikController::class, 'jadwalIbadah'])->name('jadwal-ibadah');

Route::get('/pengumuman', [PublikController::class, 'pengumuman'])->name('pengumuman');
Route::get('/pengumuman/{id}', [PublikController::class, 'pengumumanDetail'])->name('pengumuman.detail');

Route::get('/musik', [PublikController::class, 'musik'])->name('musik');
Route::get('/galeri', [PublikController::class, 'galeri'])->name('galeri');

Route::get('/gembala', [PublikController::class, 'gembala'])->name('gembala');
Route::get('/program', [PublikController::class, 'program'])->name('program');

Route::get('/about', [PublikController::class, 'about'])->name('about');
Route::get('/lokasi', [PublikController::class, 'lokasi'])->name('lokasi');

Route::get('/jadwal-pelayan', [PublikController::class, 'jadwalPelayan'])->name('jadwal-pelayan');


/*
|--------------------------------------------------------------------------
| RUTE PELAYAN
|--------------------------------------------------------------------------
*/

Route::prefix('pelayan')->middleware(['auth', 'role:pelayan'])->group(function () {

    Route::get('/dashboard', [PelayanDashboard::class, 'index'])->name('pelayan.dashboard');

    Route::get('/jadwal', [PelayanDashboard::class, 'jadwal'])->name('pelayan.jadwal');

    Route::get('/tukar-jadwal', [PelayanDashboard::class, 'tukarJadwal'])->name('pelayan.tukar-jadwal');
    Route::post('/tukar-jadwal', [PelayanDashboard::class, 'storeTukarJadwal'])->name('pelayan.tukar-jadwal.store');

    Route::get('/profil', [PelayanDashboard::class, 'profil'])->name('pelayan.profil');
    Route::post('/profil', [PelayanDashboard::class, 'updateProfil'])->name('pelayan.profil.update');

});


/*
|--------------------------------------------------------------------------
| RUTE GEMBALA
|--------------------------------------------------------------------------
*/

Route::prefix('gembala-panel')->middleware(['auth', 'role:gembala'])->group(function () {

    Route::get('/dashboard', [GembalaDashboard::class, 'index'])->name('gembala.dashboard');

    // Renungan
    Route::get('/renungan', [GembalaDashboard::class, 'renungan'])->name('gembala.renungan');
    Route::post('/renungan', [GembalaDashboard::class, 'storeRenungan'])->name('gembala.renungan.store');
    Route::get('/renungan/{id}/edit', [GembalaDashboard::class, 'editRenungan'])->name('gembala.renungan.edit');
    Route::put('/renungan/{id}', [GembalaDashboard::class, 'updateRenungan'])->name('gembala.renungan.update');
    Route::delete('/renungan/{id}', [GembalaDashboard::class, 'destroyRenungan'])->name('gembala.renungan.destroy');

    // Pengumuman
    Route::get('/pengumuman', [GembalaDashboard::class, 'pengumuman'])->name('gembala.pengumuman');
    Route::post('/pengumuman', [GembalaDashboard::class, 'storePengumuman'])->name('gembala.pengumuman.store');

    // Jadwal
    Route::get('/jadwal', [GembalaDashboard::class, 'jadwal'])->name('gembala.jadwal');

    // Profil
    Route::get('/profil', [GembalaDashboard::class, 'profil'])->name('gembala.profil');
    Route::post('/profil', [GembalaDashboard::class, 'updateProfil'])->name('gembala.profil.update');

});


/*
|--------------------------------------------------------------------------
| RUTE ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');


    /*
    |------------------------------------------------
    | JEMAAT
    |------------------------------------------------
    */

    Route::get('/jemaat', [App\Http\Controllers\Admin\JemaatController::class, 'index'])->name('admin.jemaat');
    Route::post('/jemaat', [App\Http\Controllers\Admin\JemaatController::class, 'store'])->name('admin.jemaat.store');

    Route::get('/jemaat/export', [App\Http\Controllers\Admin\JemaatController::class, 'export'])->name('admin.jemaat.export');
    Route::get('/jemaat/template', [App\Http\Controllers\Admin\JemaatController::class, 'template'])->name('admin.jemaat.template');
    Route::post('/jemaat/import', [App\Http\Controllers\Admin\JemaatController::class, 'import'])->name('admin.jemaat.import');

    Route::get('/jemaat/{id}/edit', [App\Http\Controllers\Admin\JemaatController::class, 'edit'])->name('admin.jemaat.edit');
    Route::put('/jemaat/{id}', [App\Http\Controllers\Admin\JemaatController::class, 'update'])->name('admin.jemaat.update');
    Route::delete('/jemaat/{id}', [App\Http\Controllers\Admin\JemaatController::class, 'destroy'])->name('admin.jemaat.destroy');


    /*
    |------------------------------------------------
    | PENGGUNA (USER MANAGEMENT)
    |------------------------------------------------
    */

    Route::get('/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna');
    Route::post('/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'store'])->name('admin.pengguna.store');

    Route::get('/pengguna/{id}/edit', [App\Http\Controllers\Admin\PenggunaController::class, 'edit'])->name('admin.pengguna.edit');
    Route::put('/pengguna/{id}', [App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('admin.pengguna.update');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');


    /*
    |------------------------------------------------
    | RENUNGAN
    |------------------------------------------------
    */

    Route::get('/renungan', [App\Http\Controllers\Admin\RenunganController::class, 'index'])->name('admin.renungan');
    Route::post('/renungan', [App\Http\Controllers\Admin\RenunganController::class, 'store'])->name('admin.renungan.store');

    Route::get('/renungan/{id}/edit', [App\Http\Controllers\Admin\RenunganController::class, 'edit'])->name('admin.renungan.edit');
    Route::put('/renungan/{id}', [App\Http\Controllers\Admin\RenunganController::class, 'update'])->name('admin.renungan.update');
    Route::delete('/renungan/{id}', [App\Http\Controllers\Admin\RenunganController::class, 'destroy'])->name('admin.renungan.destroy');


    /*
    |------------------------------------------------
    | PENGUMUMAN
    |------------------------------------------------
    */

    Route::get('/pengumuman', [App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('admin.pengumuman');
    Route::post('/pengumuman', [App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('admin.pengumuman.store');

    Route::get('/pengumuman/{id}/edit', [App\Http\Controllers\Admin\PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::put('/pengumuman/{id}', [App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{id}', [App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');


    /*
    |------------------------------------------------
    | GALERI
    |------------------------------------------------
    */

    Route::get('/galeri', [App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('admin.galeri');
    Route::post('/galeri', [App\Http\Controllers\Admin\GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::delete('/galeri/{id}', [App\Http\Controllers\Admin\GaleriController::class, 'destroy'])->name('admin.galeri.destroy');


    /*
    |------------------------------------------------
    | MUSIK
    |------------------------------------------------
    */

    Route::get('/musik', [App\Http\Controllers\Admin\MusikController::class, 'index'])->name('admin.musik');
    Route::post('/musik', [App\Http\Controllers\Admin\MusikController::class, 'store'])->name('admin.musik.store');
    Route::delete('/musik/{id}', [App\Http\Controllers\Admin\MusikController::class, 'destroy'])->name('admin.musik.destroy');


    /*
    |------------------------------------------------
    | SLIDESHOW
    |------------------------------------------------
    */

    Route::get('/slideshow', [App\Http\Controllers\Admin\SlideshowController::class, 'index'])->name('admin.slideshow');
    Route::post('/slideshow', [App\Http\Controllers\Admin\SlideshowController::class, 'store'])->name('admin.slideshow.store');
    Route::post('slideshow/reorder', [App\Http\Controllers\Admin\SlideshowController::class, 'reorder'])->name('admin.slideshow.reorder');
    Route::delete('/slideshow/{id}', [App\Http\Controllers\Admin\SlideshowController::class, 'destroy'])->name('admin.slideshow.destroy');
    Route::patch('/slideshow/{id}/toggle', [App\Http\Controllers\Admin\SlideshowController::class, 'toggleActive'])->name('admin.slideshow.toggle');
    

    /*
    |------------------------------------------------
    | PROGRAM GEREJA
    |------------------------------------------------
    */

    Route::get('/program', [App\Http\Controllers\Admin\ProgramController::class, 'index'])->name('admin.program');
    Route::post('/program', [App\Http\Controllers\Admin\ProgramController::class, 'store'])->name('admin.program.store');
    Route::get('/program/{id}/edit', [App\Http\Controllers\Admin\ProgramController::class, 'edit'])->name('admin.program.edit');
    Route::put('/program/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'update'])->name('admin.program.update');
    Route::delete('/program/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'destroy'])->name('admin.program.destroy');


    /*
    |------------------------------------------------
    | KELUARGA GEMBALA
    |------------------------------------------------
    */

    Route::get('/gembala', [App\Http\Controllers\Admin\KeluargaGembalaController::class, 'index'])->name('admin.gembala');
    Route::post('/gembala', [App\Http\Controllers\Admin\KeluargaGembalaController::class, 'store'])->name('admin.gembala.store');
    Route::get('/gembala/{id}/edit', [App\Http\Controllers\Admin\KeluargaGembalaController::class, 'edit'])->name('admin.gembala.edit');
    Route::put('/gembala/{id}', [App\Http\Controllers\Admin\KeluargaGembalaController::class, 'update'])->name('admin.gembala.update');
    Route::delete('/gembala/{id}', [App\Http\Controllers\Admin\KeluargaGembalaController::class, 'destroy'])->name('admin.gembala.destroy');


    /*
    |------------------------------------------------
    | KALENDER / KEGIATAN
    |------------------------------------------------
    */

    Route::get('/kalender', [App\Http\Controllers\Admin\KalenderController::class, 'index'])->name('admin.kalender');
    Route::post('/kalender', [App\Http\Controllers\Admin\KalenderController::class, 'store'])->name('admin.kalender.store');

    // Template harus sebelum {id} agar tidak konflik
    Route::patch('/kalender/template/{id}/toggle', [App\Http\Controllers\Admin\KalenderController::class, 'toggleTemplate'])->name('admin.kalender.template.toggle');
    Route::put('/kalender/template/{id}', [App\Http\Controllers\Admin\KalenderController::class, 'updateTemplate'])->name('admin.kalender.template.update');

    Route::get('/kalender/{id}/edit', [App\Http\Controllers\Admin\KalenderController::class, 'edit'])->name('admin.kalender.edit');
    Route::put('/kalender/{id}', [App\Http\Controllers\Admin\KalenderController::class, 'update'])->name('admin.kalender.update');
    Route::delete('/kalender/{id}', [App\Http\Controllers\Admin\KalenderController::class, 'destroy'])->name('admin.kalender.destroy');


           /*
    |------------------------------------------------
    | JADWAL IBADAH MINGGU
    |------------------------------------------------
    */

    // Tampil halaman utama + navigasi minggu
    Route::get('/jadwal-ibadah-minggu', [App\Http\Controllers\Admin\JadwalIbadahMingguController::class, 'index'])
        ->name('admin.jadwal-ibadah-minggu');

    // Update nama pelayan pada posisi yang sudah ada (POST MURNI - tanpa @method)
    Route::post('/jadwal-ibadah-minggu/update', [App\Http\Controllers\Admin\JadwalIbadahMingguController::class, 'update'])
        ->name('admin.jadwal-ibadah-minggu.update');

    // Tambah posisi baru dalam grup (custom position)
    Route::post('/jadwal-ibadah-minggu/store', [App\Http\Controllers\Admin\JadwalIbadahMingguController::class, 'storePosisiCustom'])
        ->name('admin.jadwal-ibadah-minggu.store');

    // Hapus posisi custom
    Route::delete('/jadwal-ibadah-minggu/{id}', [App\Http\Controllers\Admin\JadwalIbadahMingguController::class, 'destroy'])
        ->name('admin.jadwal-ibadah-minggu.destroy');

    // Toggle visibilitas (tampil/sembunyi) - pakai PATCH
    Route::patch('/jadwal-ibadah-minggu/{id}/toggle-visible', [App\Http\Controllers\Admin\JadwalIbadahMingguController::class, 'toggleVisible'])
        ->name('admin.jadwal-ibadah-minggu.toggle-visible');

        /*
    |------------------------------------------------
    | JADWAL WL (WORSHIP LEADER)
    |------------------------------------------------
    */

    // Tampil halaman jadwal WL
    Route::get('/jadwal-wl', [App\Http\Controllers\Admin\JadwalWlController::class, 'index'])
        ->name('admin.jadwal-wl');

    // Simpan/Update WL
    Route::post('/jadwal-wl', [App\Http\Controllers\Admin\JadwalWlController::class, 'store'])
        ->name('admin.jadwal-wl.store');

    // Hapus WL
    Route::delete('/jadwal-wl/{id}', [App\Http\Controllers\Admin\JadwalWlController::class, 'destroy'])
        ->name('admin.jadwal-wl.destroy');

    /*
    |------------------------------------------------
    | TUKAR JADWAL
    |------------------------------------------------
    */

    Route::get('/tukar-jadwal', [App\Http\Controllers\Admin\TukarJadwalController::class, 'index'])->name('admin.tukar-jadwal');
    Route::patch('/tukar-jadwal/{id}/approve', [App\Http\Controllers\Admin\TukarJadwalController::class, 'approve'])->name('admin.tukar-jadwal.approve');
    Route::patch('/tukar-jadwal/{id}/reject', [App\Http\Controllers\Admin\TukarJadwalController::class, 'reject'])->name('admin.tukar-jadwal.reject');
    Route::delete('/tukar-jadwal/{id}', [App\Http\Controllers\Admin\TukarJadwalController::class, 'destroy'])->name('admin.tukar-jadwal.destroy');


    /*
    |------------------------------------------------
    | ABOUT
    |------------------------------------------------
    */

    Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('admin.about');
    Route::post('/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

});


/*
|--------------------------------------------------------------------------
| REDIRECT SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    return match(auth()->user()->role) {

        'admin'   => redirect()->route('admin.dashboard'),
        'gembala' => redirect()->route('gembala.dashboard'),
        'pelayan' => redirect()->route('pelayan.dashboard'),

        default   => redirect()->route('beranda'),

    };

})->name('dashboard');


require __DIR__.'/auth.php';