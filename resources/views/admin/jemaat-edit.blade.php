@extends('layouts.admin')
@section('title', 'Edit Jemaat')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-3xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.jemaat') }}"
           class="flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">|</span>
        <h3 class="font-bold text-gray-800">Edit Data Jemaat</h3>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
        <ul class="list-disc ml-4 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.jemaat.update', $jemaat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Nama Lengkap --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_lengkap"
                       value="{{ old('nama_lengkap', $jemaat->nama_lengkap) }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select name="jenis_kelamin" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="Laki-laki"  {{ old('jenis_kelamin', $jemaat->jenis_kelamin) === 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"  {{ old('jenis_kelamin', $jemaat->jenis_kelamin) === 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Status Pernikahan --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pernikahan</label>
                <select name="status_pernikahan"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">— Pilih —</option>
                    <option value="Belum Menikah" {{ old('status_pernikahan', $jemaat->status_pernikahan) === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="Menikah"       {{ old('status_pernikahan', $jemaat->status_pernikahan) === 'Menikah'       ? 'selected' : '' }}>Menikah</option>
                    <option value="Janda/Duda"    {{ old('status_pernikahan', $jemaat->status_pernikahan) === 'Janda/Duda'    ? 'selected' : '' }}>Janda/Duda</option>
                </select>
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir"
                       value="{{ old('tanggal_lahir', $jemaat->tanggal_lahir ? $jemaat->tanggal_lahir->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            {{-- Pekerjaan --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan"
                       value="{{ old('pekerjaan', $jemaat->pekerjaan) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Wiraswasta, PNS, dll">
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">No HP</label>
                <input type="text" name="no_hp"
                       value="{{ old('no_hp', $jemaat->no_hp) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="08xxxxxxxxxx">
            </div>

            {{-- Nama Keluarga --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Keluarga / KK</label>
                <input type="text" name="nama_keluarga"
                       value="{{ old('nama_keluarga', $jemaat->nama_keluarga) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Nama kepala keluarga">
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat</label>
                <textarea name="alamat" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                          placeholder="Alamat lengkap...">{{ old('alamat', $jemaat->alamat) }}</textarea>
            </div>

            {{-- Tanggal Baptis --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Baptis</label>
                <input type="date" name="tanggal_baptis"
                       value="{{ old('tanggal_baptis', $jemaat->tanggal_baptis ? $jemaat->tanggal_baptis->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            {{-- Tanggal Sidi --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Sidi</label>
                <input type="date" name="tanggal_sidi"
                       value="{{ old('tanggal_sidi', $jemaat->tanggal_sidi ? $jemaat->tanggal_sidi->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            {{-- Catatan --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan</label>
                <textarea name="catatan" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                          placeholder="Catatan tambahan...">{{ old('catatan', $jemaat->catatan) }}</textarea>
            </div>

            {{-- Foto --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Foto <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span>
                </label>
                @if($jemaat->foto && file_exists(public_path('storage/'.$jemaat->foto)))
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ asset('storage/'.$jemaat->foto) }}"
                         class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200">
                    <span class="text-xs text-gray-400">Foto saat ini</span>
                </div>
                @endif
                <input type="file" name="foto" accept="image/*"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-400 mt-1">Format: jpg, png — maks 2MB</p>
            </div>

            {{-- Status Aktif --}}
            <div class="md:col-span-2">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="status_aktif" value="1"
                           {{ old('status_aktif', $jemaat->status_aktif) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 rounded border-gray-300">
                    <span class="font-medium">Jemaat Aktif</span>
                </label>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.jemaat') }}"
               class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                💾 Update
            </button>
        </div>
    </form>
</div>
@endsection