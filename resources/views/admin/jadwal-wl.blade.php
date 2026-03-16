@extends('layouts.admin')
@section('title', 'Jadwal WL Ibadah')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center justify-between">
    <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-start gap-2">
    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- Header --}}
<div class="mb-6">
    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Jadwal Pelayan</p>
    <h1 class="text-xl font-bold text-gray-800">🎤 Worship Leader - Kegiatan Tengah Minggu</h1>
    <p class="text-sm text-gray-500 mt-1">Tetapkan WL untuk ibadah selain Ibadah Raya Minggu</p>
</div>

{{-- Tab Navigation --}}
<div class="flex gap-2 mb-6 border-b border-gray-200 pb-1">
    <a href="{{ route('admin.jadwal-ibadah-minggu') }}" 
       class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 transition">
        📅 Ibadah Minggu
    </a>
    <a href="{{ route('admin.jadwal-wl') }}" 
       class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
        🎤 WL Kegiatan
    </a>
</div>

{{-- Tabel Kegiatan + WL --}}
@if($kegiatan->count() > 0)
<div class="space-y-3">
    @foreach($kegiatan as $k)
    @php 
        // ✅ PERBAIKAN: $jadwalWL->get() mengembalikan STRING (nama_wl), bukan object
        $wlNama = $jadwalWL->get($k->id); 
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-center p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition">

        {{-- Info Kegiatan --}}
        <div class="md:col-span-2 flex items-center gap-3">
            <div class="w-2 h-12 rounded-full flex-shrink-0" 
                 style="background-color: {{ $k->warna ?? '#3b82f6' }}"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">
                    {{ $k->nama_kegiatan }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $k->tanggal->translatedFormat('l, d F Y') }} •
                    {{ substr($k->jam_mulai, 0, 5) }} WIB
                </p>
            </div>
        </div>

        {{-- WL Sekarang --}}
        <div>
            @if($wlNama)
            <div class="flex items-center gap-2">
                {{-- ✅ PERBAIKAN: $wlNama adalah string, langsung tampilkan --}}
                <span class="text-sm font-medium text-green-700 bg-green-50 px-3 py-1.5 rounded-lg">
                    🎤 {{ $wlNama }}
                </span>
            </div>
            @else
            <span class="text-xs text-gray-400 italic">Belum ada WL</span>
            @endif
        </div>

        {{-- Form Set WL --}}
        <div>
            <form action="{{ route('admin.jadwal-wl.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="kegiatan_id" value="{{ $k->id }}">

                {{-- Input dengan datalist dari akun pelayan --}}
                <input type="text"
                       name="nama_wl"
                       list="list-pelayan"
                       value="{{ $wlNama ?? '' }}"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Nama WL...">

                <button type="submit"
                        class="bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-800 transition flex-shrink-0"
                        title="Simpan">
                    💾
                </button>

                {{-- Tombol Hapus (hanya jika WL sudah ada) --}}
                @if($wlNama)
                <button type="button"
                        onclick="if(confirm('Hapus WL ini?')) document.getElementById('del-wl-{{ $k->id }}').submit()"
                        class="bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-200 transition flex-shrink-0"
                        title="Hapus">
                    ✕
                </button>
                {{-- Form DELETE tersembunyi --}}
                <form id="del-wl-{{ $k->id }}"
                      action="{{ route('admin.jadwal-wl.destroy', $k->id) }}"
                      method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endif
            </form>
        </div>

    </div>
    @endforeach
</div>

{{-- Datalist nama pelayan --}}
<datalist id="list-pelayan">
    @foreach($pelayan as $p)
    <option value="{{ $p->name }}">
    @endforeach
</datalist>

@else
<div class="text-center py-12">
    <p class="text-5xl mb-3">📅</p>
    <p class="text-gray-400">Belum ada kegiatan minggu ini.</p>
    <a href="{{ route('admin.kalender') }}"
       class="text-blue-600 text-sm font-medium hover:text-blue-800 mt-2 inline-block">
        Tambah kegiatan di Kalender →
    </a>
</div>
@endif

@endsection