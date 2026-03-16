<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramGereja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
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
            $path = $request->file('foto')->store('program', 'public');
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
            if ($program->foto) Storage::disk('public')->delete($program->foto);
            $data['foto'] = $request->file('foto')->store('program', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.program')
            ->with('success', 'Program berhasil diupdate!');
    }

    public function destroy($id)
    {
        $program = ProgramGereja::findOrFail($id);
        if ($program->foto) Storage::disk('public')->delete($program->foto);
        $program->delete();

        return redirect()->route('admin.program')
            ->with('success', 'Program berhasil dihapus!');
    }
}