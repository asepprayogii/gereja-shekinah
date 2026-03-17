<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramGereja;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class ProgramController extends Controller
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

    public function index()
    {
        $program = ProgramGereja::orderBy('urutan')->paginate(10);
        return view('admin.program', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/program']
            );
            $path = $result['secure_url'];
        }

        ProgramGereja::create([
            'nama_program' => $request->nama_program,
            'deskripsi'    => $request->deskripsi,
            'foto'         => $path,
            'link_info'    => $request->link_info,
            'urutan'       => ProgramGereja::count() + 1,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()->route('admin.program')
            ->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $program = ProgramGereja::findOrFail($id);
        return view('admin.program-edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = ProgramGereja::findOrFail($id);

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama_program' => $request->nama_program,
            'deskripsi'    => $request->deskripsi,
            'link_info'    => $request->link_info,
            'is_active'    => $request->has('is_active'),
        ];

        if ($request->hasFile('foto')) {
            $this->hapusDariCloudinary($program->foto);
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/program']
            );
            $data['foto'] = $result['secure_url'];
        }

        $program->update($data);

        return redirect()->route('admin.program')
            ->with('success', 'Program berhasil diupdate!');
    }

    public function destroy($id)
    {
        $program = ProgramGereja::findOrFail($id);
        $this->hapusDariCloudinary($program->foto);
        $program->delete();

        return redirect()->route('admin.program')
            ->with('success', 'Program berhasil dihapus!');
    }
}
