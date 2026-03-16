@extends('layouts.admin')
@section('title', 'Edit Program')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.program') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Kembali</a>
        <h3 class="font-bold text-gray-800">✏️ Edit Program</h3>
    </div>
    <form action="{{ route('admin.program.update', $program->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Program *</label>
                <input type="text" name="nama_program" value="{{ $program->nama_program }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Baru</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @if($program->foto)
                <img src="{{ asset('storage/' . $program->foto) }}" class="mt-2 h-16 rounded">
                @endif
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">{{ $program->deskripsi }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link Info</label>
                <input type="url" name="link_info" value="{{ $program->link_info }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div class="flex items-center gap-2 mt-5">
                <input type="checkbox" name="is_active" value="1"
                       {{ $program->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                <label class="text-sm text-gray-700">Tampilkan di halaman publik</label>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.program') }}"
               class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit"
                    class="px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                💾 Update
            </button>
        </div>
    </form>
</div>
@endsection