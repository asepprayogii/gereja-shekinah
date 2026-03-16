@extends('layouts.admin')
@section('title', 'Data Jemaat')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center justify-between">
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-green-500 ml-3">✕</button>
</div>
@endif
@if(session('import_errors') && count(session('import_errors')) > 0)
<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl mb-4 text-sm">
    <p class="font-semibold mb-1">Beberapa baris gagal diimport:</p>
    <ul class="list-disc ml-4 space-y-0.5 text-xs">
        @foreach(session('import_errors') as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-2 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">Total Jemaat</p>
        <p class="text-2xl sm:text-3xl font-bold text-blue-700">{{ $total }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">Jemaat Aktif</p>
        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $totalAktif }}</p>
    </div>
</div>

{{-- Toolbar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">

    {{-- Search form --}}
    <form method="GET" action="{{ route('admin.jemaat') }}" class="flex gap-2 mb-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama, keluarga, No HP..."
               class="flex-1 min-w-0 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        <select name="filter"
                class="border border-gray-200 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">Semua</option>
            <option value="aktif"    {{ request('filter')==='aktif'    ? 'selected':'' }}>Aktif</option>
            <option value="nonaktif" {{ request('filter')==='nonaktif' ? 'selected':'' }}>Nonaktif</option>
        </select>
        <button type="submit"
                class="bg-blue-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-800 transition flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </form>

    {{-- Action buttons --}}
    <div class="flex flex-wrap gap-2 items-center">

        {{-- Export CSV --}}
        <a href="{{ route('admin.jemaat.export') }}"
           title="Export CSV"
           class="flex items-center justify-center w-9 h-9 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
        </a>

        {{-- Template CSV --}}
        <a href="{{ route('admin.jemaat.template') }}"
           title="Download Template CSV"
           class="flex items-center justify-center w-9 h-9 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </a>

        {{-- Import CSV --}}
        <button onclick="document.getElementById('modal-import').classList.remove('hidden')"
                title="Import CSV"
                class="flex items-center justify-center w-9 h-9 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
        </button>

        {{-- Tambah Jemaat --}}
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-2 bg-blue-700 text-white rounded-lg text-xs font-semibold hover:bg-blue-800 transition ml-auto">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jemaat
        </button>
    </div>
</div>

{{-- ── DESKTOP: Tabel ── --}}
@if($jemaat->count() > 0)
<div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-left text-xs uppercase tracking-wider">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Keluarga</th>
                <th class="px-4 py-3">Tgl Lahir</th>
                <th class="px-4 py-3">Baptis</th>
                <th class="px-4 py-3">No HP</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($jemaat as $j)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        @if($j->foto && file_exists(public_path('storage/'.$j->foto)))
                            <img src="{{ asset('storage/'.$j->foto) }}"
                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                                {{ $j->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ strtoupper(substr($j->nama_lengkap, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $j->nama_lengkap }}</p>
                            <p class="text-xs text-gray-400">{{ $j->pekerjaan ?: '—' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $j->nama_keluarga ?: '—' }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs">
                    @if($j->tanggal_lahir)
                        {{ $j->tanggal_lahir->format('d/m/Y') }}
                        <span class="text-gray-400">({{ $j->tanggal_lahir->age }}th)</span>
                    @else —
                    @endif
                </td>
                <td class="px-4 py-3 text-xs">
                    @if($j->tanggal_baptis)
                        <span class="text-green-600 font-medium">Sudah</span>
                    @else
                        <span class="text-gray-300">Belum</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $j->no_hp ?: '—' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                        {{ $j->status_aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                        {{ $j->status_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.jemaat.edit', $j->id) }}"
                           class="text-blue-600 hover:text-blue-800 text-xs font-medium">Edit</a>
                        <form action="{{ route('admin.jemaat.destroy', $j->id) }}" method="POST"
                              onsubmit="return confirm('Hapus {{ addslashes($j->nama_lengkap) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-50">{{ $jemaat->links() }}</div>
</div>

{{-- ── MOBILE: Card List ── --}}
<div class="md:hidden space-y-2">
    @foreach($jemaat as $j)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                @if($j->foto && file_exists(public_path('storage/'.$j->foto)))
                    <img src="{{ asset('storage/'.$j->foto) }}"
                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold
                        {{ $j->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                        {{ strtoupper(substr($j->nama_lengkap, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $j->nama_lengkap }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $j->pekerjaan ?: 'Pekerjaan tidak diisi' }}</p>
                </div>
            </div>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0 mt-0.5
                {{ $j->status_aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                {{ $j->status_aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div class="mt-3 pt-3 border-t border-gray-50 grid grid-cols-2 gap-y-2 gap-x-4 text-xs">
            <div>
                <p class="text-gray-400">No HP</p>
                <p class="text-gray-700 font-medium">{{ $j->no_hp ?: '—' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tgl Lahir</p>
                <p class="text-gray-700 font-medium">
                    @if($j->tanggal_lahir)
                        {{ $j->tanggal_lahir->format('d/m/Y') }} ({{ $j->tanggal_lahir->age }}th)
                    @else —
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-400">Baptis</p>
                <p class="{{ $j->tanggal_baptis ? 'text-green-600' : 'text-gray-400' }} font-medium">
                    {{ $j->tanggal_baptis ? 'Sudah' : 'Belum' }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Status Nikah</p>
                <p class="text-gray-700 font-medium">{{ $j->status_pernikahan ?: '—' }}</p>
            </div>
            @if($j->nama_keluarga)
            <div class="col-span-2">
                <p class="text-gray-400">Nama Keluarga</p>
                <p class="text-gray-700 font-medium">{{ $j->nama_keluarga }}</p>
            </div>
            @endif
        </div>

        <div class="mt-3 pt-3 border-t border-gray-50 flex gap-2">
            <a href="{{ route('admin.jemaat.edit', $j->id) }}"
               class="flex-1 text-center py-2 text-xs font-semibold text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                Edit
            </a>
            <form action="{{ route('admin.jemaat.destroy', $j->id) }}" method="POST"
                  onsubmit="return confirm('Hapus {{ addslashes($j->nama_lengkap) }}?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach
    <div class="pt-2">{{ $jemaat->links() }}</div>
</div>

@else
{{-- Empty state --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>
    <p class="text-gray-500 font-medium text-sm">Belum ada data jemaat.</p>
    <p class="text-gray-400 text-xs mt-1">Klik tombol Tambah atau Import CSV.</p>
</div>
@endif

{{-- ===== MODAL TAMBAH ===== --}}
<div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl my-6">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl z-10">
            <h3 class="font-bold text-gray-800">Tambah Jemaat</h3>
            <button onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl">&times;</button>
        </div>
        <form action="{{ route('admin.jemaat.store') }}" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Nama lengkap tanpa gelar">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pernikahan</label>
                    <select name="status_pernikahan"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="">— Pilih —</option>
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Menikah">Menikah</option>
                        <option value="Janda/Duda">Janda/Duda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Wiraswasta, PNS, dll">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">No HP</label>
                    <input type="text" name="no_hp"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Keluarga / KK</label>
                    <input type="text" name="nama_keluarga"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Nama kepala keluarga">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                              placeholder="Alamat lengkap..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Baptis</label>
                    <input type="date" name="tanggal_baptis"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Sidi</label>
                    <input type="date" name="tanggal_sidi"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Foto <span class="text-gray-400 font-normal">(opsional, jpg/png maks 2MB)</span>
                    </label>
                    <input type="file" name="foto" accept="image/*"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan</label>
                    <textarea name="catatan" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                              placeholder="Catatan tambahan..."></textarea>
                </div>

            </div>
            <div class="flex justify-end gap-3 mt-5 pt-4 border-t border-gray-100">
                <button type="button"
                        onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL IMPORT ===== --}}
<div id="modal-import" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Import Data Jemaat</h3>
            <button onclick="document.getElementById('modal-import').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl">&times;</button>
        </div>
        <div class="p-5">
            <div class="bg-blue-50 rounded-xl p-4 mb-4">
                <p class="text-xs font-semibold text-blue-700 mb-2">Petunjuk Import:</p>
                <ol class="list-decimal ml-4 space-y-1 text-xs text-blue-600">
                    <li>Download template CSV terlebih dahulu</li>
                    <li>Isi data sesuai format kolom yang tersedia</li>
                    <li>Simpan sebagai CSV lalu upload di sini</li>
                    <li>Data yang sudah ada tidak akan terhapus</li>
                </ol>
            </div>

            <div class="flex gap-2 mb-4">
                <a href="{{ route('admin.jemaat.template') }}"
                   class="flex-1 flex items-center justify-center gap-2 py-2.5
                          border-2 border-dashed border-teal-300 text-teal-600 rounded-xl
                          text-xs font-semibold hover:bg-teal-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Template CSV
                </a>
            </div>

            <form action="{{ route('admin.jemaat.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Upload File CSV <span class="text-red-500">*</span></label>
                    <input type="file" name="file_csv" accept=".csv,.txt" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Format: .csv — maks 5MB</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="document.getElementById('modal-import').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-semibold text-white bg-orange-500 rounded-lg hover:bg-orange-600">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection