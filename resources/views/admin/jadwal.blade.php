@extends('layouts.admin')
@section('title', 'Jadwal Pelayanan')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
    {{ session('error') }}
</div>
@endif

{{-- Form Tambah --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4 text-sm">Tambah Jadwal Pelayanan</h3>
    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Tanggal --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Tanggal Ibadah *</label>
                <input type="date" name="tanggal" required value="{{ old('tanggal') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            {{-- Posisi --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Posisi *</label>
                <select name="posisi" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Posisi --</option>
                    @foreach($posisiList as $pos)
                        <option value="{{ $pos }}" {{ old('posisi') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Pelayan (dropdown dari users) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Pelayan *</label>
                <select name="nama_pelayan" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Pelayan --</option>
                    @foreach($pelayan as $p)
                        <option value="{{ $p->name }}" {{ old('nama_pelayan') == $p->name ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Urutan --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="0">
            </div>

        </div>
        <div class="mt-4">
            <button type="submit"
                    class="bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                Tambah ke Jadwal
            </button>
        </div>
    </form>
</div>

{{-- Daftar Jadwal --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 mb-4 text-sm">Daftar Jadwal Pelayanan</h3>

    @if($jadwal->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-left text-xs uppercase tracking-wide">
                    <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                    <th class="px-4 py-3">Posisi</th>
                    <th class="px-4 py-3">Nama Pelayan</th>
                    <th class="px-4 py-3">Urutan</th>
                    <th class="px-4 py-3">Tampil</th>
                    <th class="px-4 py-3 rounded-r-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($jadwal as $j)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-700 font-medium whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">
                            {{ $j->posisi }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-800 font-medium">
                        {{ $j->nama_pelayan ?: '-' }}
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">
                        {{ $j->urutan }}
                    </td>
                    <td class="px-4 py-3">
                        @if($j->is_visible)
                            <span class="px-2 py-1 bg-green-50 text-green-600 rounded-full text-xs">Tampil</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-400 rounded-full text-xs">Disembunyikan</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.jadwal.destroy', $j->id) }}"
                              method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $jadwal->links() }}</div>

    @else
    <div class="text-center py-10">
        <svg class="w-8 h-8 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-400 text-sm">Belum ada jadwal pelayanan.</p>
    </div>
    @endif
</div>

@endsection