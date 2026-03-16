<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalIbadahMinggu;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalIbadahMingguController extends Controller
{
    public function index()
    {
        // Tentukan tanggal ibadah minggu yang ditampilkan
        if (request('tanggal')) {
            $tanggalIbadah = Carbon::parse(request('tanggal'))->startOfDay();
        } else {
            $tanggalIbadah = Carbon::now()->next(Carbon::SUNDAY)->startOfDay();
        }

        // Ambil jadwal untuk tanggal tersebut
        $jadwal = JadwalIbadahMinggu::whereDate('tanggal', $tanggalIbadah)
            ->orderBy('urutan')
            ->get();

        // Jika kosong, generate posisi default
        if ($jadwal->isEmpty()) {
            $this->generatePosisiKosong($tanggalIbadah);
            $jadwal = JadwalIbadahMinggu::whereDate('tanggal', $tanggalIbadah)
                ->orderBy('urutan')
                ->get();
        }

        // Generate daftar 16 minggu untuk dropdown navigasi
        $daftarMinggu = [];
        $start = Carbon::now()->next(Carbon::SUNDAY)->subWeeks(8);
        for ($i = 0; $i < 16; $i++) {
            $daftarMinggu[] = $start->copy()->addWeeks($i);
        }

        // Load konfigurasi posisi & grup dari Model
        $posisiList  = JadwalIbadahMinggu::$posisiList;
        $grupPosisi  = JadwalIbadahMinggu::$grupPosisi;

        // Load daftar pelayan (role: pelayan atau gembala)
        $pelayan = User::whereIn('role', ['pelayan', 'gembala'])
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-ibadah-minggu', compact(
            'jadwal', 'tanggalIbadah', 'daftarMinggu',
            'posisiList', 'grupPosisi', 'pelayan'
        ));
    }

    /**
     * Generate posisi kosong berdasarkan $posisiList default
     */
    private function generatePosisiKosong(Carbon $tanggal)
    {
        $posisiList = JadwalIbadahMinggu::$posisiList;
        $urutan = 1;
        
        foreach ($posisiList as $key => $label) {
            JadwalIbadahMinggu::firstOrCreate(
                ['tanggal' => $tanggal->format('Y-m-d'), 'posisi' => $key],
                [
                    'nama_pelayan' => '',
                    'urutan'       => $urutan++,
                    'is_visible'   => true,
                ]
            );
        }
    }

    /**
     * Update nama pelayan untuk multiple posisi
     */
    public function update(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jadwal'  => 'required|array',
        ]);

        $namaPelayan    = [];
        $duplicateNames = [];

        // Validasi: satu nama tidak boleh muncul di 2+ posisi
        foreach ($request->jadwal as $id => $data) {
            $nama = trim(strtolower($data['nama_pelayan'] ?? ''));
            
            if ($nama !== '') {
                if (isset($namaPelayan[$nama])) {
                    if (!in_array(trim($data['nama_pelayan']), $duplicateNames)) {
                        $duplicateNames[] = trim($data['nama_pelayan']);
                    }
                } else {
                    $namaPelayan[$nama] = $id;
                }
            }
        }

        if (!empty($duplicateNames)) {
            return back()->with('error',
                'Tidak dapat menyimpan jadwal. Nama "' . implode('", "', $duplicateNames) .
                '" muncul di lebih dari 1 posisi. Satu orang hanya bisa melayani 1 posisi per minggu.'
            );
        }

        // Simpan perubahan
        foreach ($request->jadwal as $id => $data) {
            JadwalIbadahMinggu::where('id', $id)->update([
                'nama_pelayan' => trim($data['nama_pelayan'] ?? ''),
            ]);
        }

        return redirect()->route('admin.jadwal-ibadah-minggu', [
            'tanggal' => $request->tanggal
        ])->with('success', 'Jadwal ibadah minggu berhasil disimpan!');
    }

    /**
     * Tambah posisi custom dalam grup tertentu
     */
    public function storePosisiCustom(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'grup'         => 'required|string|max:100',
            'nama_pelayan' => 'nullable|string|max:255',
        ]);

        $tanggal = Carbon::parse($request->tanggal);
        $nama    = trim(strtolower($request->nama_pelayan ?? ''));

        // Validasi: cek duplikasi nama pelayan di minggu yang sama
        if ($nama !== '') {
            $exists = JadwalIbadahMinggu::whereDate('tanggal', $tanggal)
                ->whereRaw('LOWER(TRIM(nama_pelayan)) = ?', [$nama])
                ->exists();

            if ($exists) {
                return back()->with('error',
                    'Nama "' . $request->nama_pelayan . '" sudah bertugas di posisi lain minggu ini.'
                );
            }
        }

        $grupPosisi = JadwalIbadahMinggu::$grupPosisi;
        $grupKey    = $request->grup; // e.g. 'singer', 'penerima_tamu'

        // Hitung jumlah posisi yang sudah ada dalam grup ini untuk penomoran otomatis
        $existingCount = JadwalIbadahMinggu::whereDate('tanggal', $tanggal)
            ->where(function($query) use ($grupKey) {
                $query->where('posisi', $grupKey)
                      ->orWhere('posisi', 'like', $grupKey . '_%');
            })
            ->count();

        // Buat key & label posisi baru
        $newKey   = $existingCount > 0 ? $grupKey . '_' . ($existingCount + 1) : $grupKey;
        $newLabel = ucwords(str_replace('_', ' ', $grupKey)) . ($existingCount > 0 ? ' ' . ($existingCount + 1) : '');
        
        // Urutan terakhir + 1
        $urutan = (JadwalIbadahMinggu::whereDate('tanggal', $tanggal)->max('urutan') ?? 0) + 1;

        JadwalIbadahMinggu::create([
            'tanggal'      => $tanggal->format('Y-m-d'),
            'posisi'       => $newKey,
            'nama_pelayan' => trim($request->nama_pelayan ?? ''),
            'urutan'       => $urutan,
            'is_visible'   => true,
        ]);

        return redirect()->route('admin.jadwal-ibadah-minggu', [
            'tanggal' => $request->tanggal
        ])->with('success', 'Posisi "' . $newLabel . '" berhasil ditambahkan!');
    }

    /**
     * Hapus posisi custom
     */
    public function destroy($id)
    {
        $jadwal  = JadwalIbadahMinggu::findOrFail($id);
        $tanggal = $jadwal->tanggal->format('Y-m-d');
        
        // Jangan hapus posisi default dari $posisiList
        if (array_key_exists($jadwal->posisi, JadwalIbadahMinggu::$posisiList)) {
            return back()->with('error', 'Posisi default tidak dapat dihapus.');
        }
        
        $jadwal->delete();

        return redirect()->route('admin.jadwal-ibadah-minggu', [
            'tanggal' => $tanggal
        ])->with('success', 'Posisi berhasil dihapus!');
    }

    /**
     * Toggle visibilitas posisi
     */
    public function toggleVisible($id)
    {
        $jadwal  = JadwalIbadahMinggu::findOrFail($id);
        $tanggal = $jadwal->tanggal->format('Y-m-d');
        
        $jadwal->update(['is_visible' => !$jadwal->is_visible]);

        return redirect()->route('admin.jadwal-ibadah-minggu', ['tanggal' => $tanggal])
            ->with('success', 'Visibilitas berhasil diubah!');
    }
}