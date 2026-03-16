@extends('layouts.pelayan')
@section('title', 'Dashboard Pelayan')

@section('content')

{{-- Selamat Datang --}}
<div class="bg-gradient-to-r from-blue-700 to-blue-800 rounded-2xl p-6 mb-6 text-white">
    <p class="text-blue-200 text-sm mb-1">Selamat datang kembali 🙏</p>
    <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
    <p class="text-blue-200 text-sm mt-1">Pelayan GPdI Shekinah Pangkalan Buntu</p>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
        <p class="text-3xl font-bold text-blue-700">{{ $totalJadwal }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Jadwal</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
        <p class="text-3xl font-bold text-green-600">
            {{ $jadwalPelayanan->count() + $jadwalMinggu->count() }}
        </p>
        <p class="text-xs text-gray-500 mt-1">Jadwal Mendatang</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center col-span-2 md:col-span-1">
        <p class="text-3xl font-bold text-orange-500">{{ $requestPending }}</p>
        <p class="text-xs text-gray-500 mt-1">Request Tukar Pending</p>
    </div>
</div>

{{-- Jadwal Ibadah Minggu Mendatang --}}
@if($jadwalMinggu->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">⛪ Jadwal Ibadah Minggu</h3>
        <a href="{{ route('pelayan.jadwal') }}"
           class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
    </div>
    <div class="space-y-3">
        @foreach($jadwalMinggu as $j)
        <div class="flex items-center gap-4 p-3 rounded-xl bg-blue-50 border border-blue-100">
            <div class="w-12 h-12 rounded-xl bg-blue-700 flex flex-col items-center justify-center flex-shrink-0">
                <p class="text-white text-xs font-bold leading-none">{{ $j->tanggal->format('d') }}</p>
                <p class="text-blue-200 text-xs leading-none mt-0.5">{{ $j->tanggal->translatedFormat('M') }}</p>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800 text-sm">Ibadah Hari Minggu</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $j->tanggal->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium flex-shrink-0">
                {{ \App\Models\JadwalIbadahMinggu::$posisiList[$j->posisi] ?? $j->posisi }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Jadwal Pelayanan Mendatang --}}
@if($jadwalPelayanan->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">📋 Jadwal Pelayanan Lainnya</h3>
        <a href="{{ route('pelayan.jadwal') }}"
           class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
    </div>
    <div class="space-y-3">
        @foreach($jadwalPelayanan as $j)
        <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-gray-600 flex flex-col items-center justify-center flex-shrink-0">
                <p class="text-white text-xs font-bold leading-none">{{ $j->kegiatan->tanggal->format('d') }}</p>
                <p class="text-gray-200 text-xs leading-none mt-0.5">{{ $j->kegiatan->tanggal->translatedFormat('M') }}</p>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800 text-sm">{{ $j->kegiatan->nama_kegiatan }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $j->kegiatan->tanggal->translatedFormat('l, d F Y') }} •
                    {{ substr($j->kegiatan->jam_mulai, 0, 5) }} WIB
                </p>
            </div>
            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium flex-shrink-0">
                {{ $j->posisi }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Kalau tidak ada jadwal sama sekali --}}
@if($jadwalPelayanan->count() === 0 && $jadwalMinggu->count() === 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6 text-center">
    <p class="text-5xl mb-3">📅</p>
    <p class="text-gray-400">Belum ada jadwal pelayanan mendatang.</p>
    <p class="text-gray-400 text-sm mt-1">Hubungi admin untuk informasi jadwal.</p>
</div>
@endif

{{-- Menu Cepat --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <a href="{{ route('pelayan.jadwal') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition text-center">
        <p class="text-3xl mb-2">📋</p>
        <p class="font-semibold text-gray-700 text-sm">Semua Jadwal</p>
    </a>
    <a href="{{ route('pelayan.tukar-jadwal') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition text-center">
        <p class="text-3xl mb-2">🔄</p>
        <p class="font-semibold text-gray-700 text-sm">Tukar Jadwal</p>
    </a>
    <a href="{{ route('pelayan.profil') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition text-center col-span-2 md:col-span-1">
        <p class="text-3xl mb-2">👤</p>
        <p class="font-semibold text-gray-700 text-sm">Profil Saya</p>
    </a>
</div>

@endsection