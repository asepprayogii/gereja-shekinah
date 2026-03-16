@extends('layouts.admin')
@section('title', 'Edit Keluarga Gembala')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.gembala') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Kembali</a>
        <h3 class="font-bold text-gray-800">✏️ Edit Anggota Keluarga Gembala</h3>
    </div>
    <form action="{{ route('admin.gembala.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                <input type="text" name="nama" value="{{ $anggota->nama }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Peran *</label>
                <select name="peran"class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Peran --</option>
                    <option value="Gembala" {{ $anggota->peran === 'Gembala' ? 'selected' : '' }}>👨‍💼 Gembala</option>
                    <option value="Ibu Gembala" {{ $anggota->peran === 'Ibu Gembala' ? 'selected' : '' }}>👩‍💼 Ibu Gembala</option>
                    <option value="Anak Gembala" {{ $anggota->peran === 'Anak Gembala' ? 'selected' : '' }}>👦 Anak Gembala</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Baru</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @if($anggota->foto)
                <img src="{{ asset('storage/' . $anggota->foto) }}"
                     class="mt-2 w-16 h-16 rounded-full object-cover border-2 border-blue-100">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea name="bio" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">{{ $anggota->bio }}</textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.gembala') }}"
               class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit"
                    class="px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                💾 Update
            </button>
        </div>
    </form>
</div>
@endsection
