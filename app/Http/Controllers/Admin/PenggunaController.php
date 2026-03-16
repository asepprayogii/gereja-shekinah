<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::whereIn('role', ['pelayan', 'gembala'])
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(15);
        return view('admin.pengguna', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:pelayan,gembala',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'no_hp'    => $request->no_hp,
        ]);

        return redirect()->route('admin.pengguna')
            ->with('success', 'Akun berhasil dibuat!');
    }

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return view('admin.pengguna-edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:pelayan,gembala',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna')
            ->with('success', 'Akun berhasil diupdate!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.pengguna')
            ->with('success', 'Akun berhasil dihapus!');
    }
}