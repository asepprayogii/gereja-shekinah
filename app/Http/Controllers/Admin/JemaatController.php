<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class JemaatController extends Controller
{
    private function getCloudinary()
    {
        return new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key'    => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
                'url' => ['secure' => true]
            ])
        );
    }

    private function hapusDariCloudinary($fotoUrl)
    {
        if ($fotoUrl && str_starts_with($fotoUrl, 'http')) {
            $path = parse_url($fotoUrl, PHP_URL_PATH);
            preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
            if (!empty($matches[1])) {
                $this->getCloudinary()->uploadApi()->destroy($matches[1]);
            }
        }
    }

    public function index(Request $request)
    {
        $query = Jemaat::query();
        if ($request->search) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama_lengkap', 'like', "%$q%")
                   ->orWhere('no_hp', 'like', "%$q%")
                   ->orWhere('nama_keluarga', 'like', "%$q%");
            });
        }
        if ($request->filter === 'aktif') {
            $query->where('status_aktif', true);
        } elseif ($request->filter === 'nonaktif') {
            $query->where('status_aktif', false);
        }
        $jemaat = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();
        $total      = Jemaat::count();
        $totalAktif = Jemaat::where('status_aktif', true)->count();
        return view('admin.jemaat', compact('jemaat', 'total', 'totalAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'foto'          => 'nullable|image|max:2048',
        ]);
        $data = $request->only([
            'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'alamat',
            'no_hp', 'status_pernikahan', 'pekerjaan',
            'tanggal_baptis', 'tanggal_sidi', 'nama_keluarga', 'catatan',
        ]);
        $data['status_aktif'] = 1;
        foreach (['tanggal_lahir', 'tanggal_baptis', 'tanggal_sidi'] as $field) {
            if (empty($data[$field])) $data[$field] = null;
        }
        if ($request->hasFile('foto')) {
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/jemaat']
            );
            $data['foto'] = $result['secure_url'];
        }
        Jemaat::create($data);
        return redirect()->route('admin.jemaat')->with('success', 'Data jemaat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jemaat = Jemaat::findOrFail($id);
        return view('admin.jemaat-edit', compact('jemaat'));
    }

    public function update(Request $request, $id)
    {
        $jemaat = Jemaat::findOrFail($id);
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'foto'          => 'nullable|image|max:2048',
        ]);
        $data = $request->only([
            'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'alamat',
            'no_hp', 'status_pernikahan', 'pekerjaan',
            'tanggal_baptis', 'tanggal_sidi', 'nama_keluarga', 'catatan',
        ]);
        $data['status_aktif'] = $request->has('status_aktif') ? 1 : 0;
        foreach (['tanggal_lahir', 'tanggal_baptis', 'tanggal_sidi'] as $field) {
            if (empty($data[$field])) $data[$field] = null;
        }
        if ($request->hasFile('foto')) {
            $this->hapusDariCloudinary($jemaat->foto);
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/jemaat']
            );
            $data['foto'] = $result['secure_url'];
        }
        $jemaat->update($data);
        return redirect()->route('admin.jemaat')->with('success', 'Data jemaat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $jemaat = Jemaat::findOrFail($id);
        $this->hapusDariCloudinary($jemaat->foto);
        $jemaat->delete();
        return redirect()->route('admin.jemaat')->with('success', 'Data jemaat berhasil dihapus!');
    }

    public function export()
    {
        $jemaat = Jemaat::orderBy('nama_lengkap')->get();
        $filename = 'jemaat-shekinah-' . date('Y-m-d') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        $callback = function () use ($jemaat) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($f, ['Nama Lengkap', 'Jenis Kelamin', 'Tanggal Lahir', 'Status Pernikahan', 'Pekerjaan', 'No HP', 'Alamat', 'Nama Keluarga', 'Tanggal Baptis', 'Tanggal Sidi', 'Catatan', 'Status Aktif']);
            foreach ($jemaat as $j) {
                fputcsv($f, [$j->nama_lengkap, $j->jenis_kelamin, $j->tanggal_lahir ? $j->tanggal_lahir->format('Y-m-d') : '', $j->status_pernikahan, $j->pekerjaan, $j->no_hp, $j->alamat, $j->nama_keluarga, $j->tanggal_baptis ? $j->tanggal_baptis->format('Y-m-d') : '', $j->tanggal_sidi ? $j->tanggal_sidi->format('Y-m-d') : '', $j->catatan, $j->status_aktif ? 'Aktif' : 'Nonaktif']);
            }
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function template()
    {
        $filename = 'template-import-jemaat.csv';
        $headers  = ['Content-Type' => 'text/csv; charset=UTF-8', 'Content-Disposition' => "attachment; filename=\"$filename\""];
        $callback = function () {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($f, ['nama_lengkap', 'jenis_kelamin(Laki-laki/Perempuan)', 'tanggal_lahir(YYYY-MM-DD)', 'status_pernikahan(Belum Menikah/Menikah/Janda/Duda)', 'pekerjaan', 'no_hp', 'alamat', 'nama_keluarga', 'tanggal_baptis(YYYY-MM-DD)', 'tanggal_sidi(YYYY-MM-DD)', 'catatan']);
            fputcsv($f, ['Budi Santoso', 'Laki-laki', '1980-05-15', 'Menikah', 'Wiraswasta', '081234567890', 'Jl. Contoh No.1', 'Keluarga Santoso', '2000-01-01', '', '']);
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate(['file_csv' => 'required|file|mimes:csv,txt|max:5120']);
        $handle = fopen($request->file('file_csv')->getRealPath(), 'r');
        $bom = fread($handle, 3);
        if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) rewind($handle);
        fgetcsv($handle);
        $berhasil = 0; $gagal = 0; $errors = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) continue;
            try {
                $nama = trim($row[0] ?? '');
                if (empty($nama)) { $gagal++; continue; }
                $jk = trim($row[1] ?? 'Laki-laki');
                if (!in_array($jk, ['Laki-laki', 'Perempuan'])) $jk = 'Laki-laki';
                $sp = trim($row[3] ?? '');
                if (!in_array($sp, ['Belum Menikah', 'Menikah', 'Janda/Duda'])) $sp = null;
                $parseDate = function ($val) { $v = trim($val ?? ''); if (empty($v)) return null; try { return \Carbon\Carbon::parse($v)->format('Y-m-d'); } catch (\Exception $e) { return null; } };
                Jemaat::create(['nama_lengkap' => $nama, 'jenis_kelamin' => $jk, 'tanggal_lahir' => $parseDate($row[2] ?? ''), 'status_pernikahan' => $sp, 'pekerjaan' => trim($row[4] ?? ''), 'no_hp' => trim($row[5] ?? ''), 'alamat' => trim($row[6] ?? ''), 'nama_keluarga' => trim($row[7] ?? ''), 'tanggal_baptis' => $parseDate($row[8] ?? ''), 'tanggal_sidi' => $parseDate($row[9] ?? ''), 'catatan' => trim($row[10] ?? ''), 'status_aktif' => 1]);
                $berhasil++;
            } catch (\Exception $e) { $gagal++; $errors[] = "Baris '" . ($row[0] ?? '?') . "': " . $e->getMessage(); }
        }
        fclose($handle);
        $msg = "Import selesai: $berhasil data berhasil diimport.";
        if ($gagal > 0) $msg .= " $gagal data gagal.";
        return redirect()->route('admin.jemaat')->with('success', $msg)->with('import_errors', $errors);
    }
}
