@extends('layouts.admin')
@section('title', 'Edit Kegiatan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.kalender') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Kembali ke Kalender
            </a>
        </div>

        <h3 class="font-bold text-gray-800 text-lg mb-1">✏️ Edit Kegiatan</h3>
        <p class="text-xs text-gray-500 mb-6">Ubah lokasi atau jam untuk kegiatan ini saja.</p>

        <form action="{{ route('admin.kalender.update', $kegiatan->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="space-y-5">
                {{-- Nama Kegiatan (Read-only hint) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                    <p class="text-gray-900 font-medium bg-gray-50 px-3 py-2.5 rounded-lg border border-gray-200">
                        {{ $kegiatan->nama_kegiatan }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Nama kegiatan diambil dari template rutin.</p>
                </div>

                {{-- Tanggal (Read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <p class="text-gray-900 font-medium bg-gray-50 px-3 py-2.5 rounded-lg border border-gray-200">
                        {{ $kegiatan->tanggal->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ substr($kegiatan->jam_mulai, 0, 5) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $kegiatan->lokasi }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Contoh: Gedung Utama, Aula Lantai 2...">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika menggunakan lokasi default.</p>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                              placeholder="Catatan tambahan...">{{ $kegiatan->keterangan }}</textarea>
                </div>

                {{-- Has WL Checkbox --}}
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="has_wl" value="1" id="has_wl"
                        {{ $kegiatan->has_wl ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 rounded border-gray-300">
                    <label for="has_wl" class="text-sm text-gray-700">🎤 Kegiatan ini memiliki Worship Leader (WL)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.kalender') }}"
                   class="px-4 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    💾 Update Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection