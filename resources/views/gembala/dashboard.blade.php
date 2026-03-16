@extends('layouts.gembala')
@section('title', 'Dashboard Gembala')

@section('content')

{{-- Selamat Datang --}}
<div class="bg-gradient-to-r from-indigo-700 to-indigo-800 rounded-2xl p-6 mb-6 text-white">
    <p class="text-indigo-200 text-sm mb-1">Selamat datang 🙏</p>
    <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
    <p class="text-indigo-200 text-sm mt-1">Gembala GPdI Shekinah Pangkalan Buntu</p>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
        <p class="text-3xl font-bold text-indigo-700">{{ $totalRenungan }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Renungan</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $totalPengumuman }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Pengumuman</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center col-span-2 md:col-span-1">
        <p class="text-3xl font-bold text-green-600">{{ $kegiatanMingguIni }}</p>
        <p class="text-xs text-gray-500 mt-1">Kegiatan Minggu Ini</p>
    </div>
</div>

{{-- Renungan Terbaru --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">📖 Renungan Terbaru Saya</h3>
        <a href="{{ route('gembala.renungan') }}"
           class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Kelola →</a>
    </div>

    @if($renunganTerbaru->count() > 0)
    <div class="space-y-3">
        @foreach($renunganTerbaru as $r)
        <div class="flex items-center justify-between p-3 rounded-xl bg-indigo-50 border border-indigo-100">
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $r->judul }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $r->tanggal_publish->translatedFormat('d F Y') }}
                </p>
            </div>
            <span class="px-2 py-1 rounded-full text-xs font-medium
                {{ $r->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $r->is_published ? '✅ Published' : '📝 Draft' }}
            </span>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-6">
        <p class="text-3xl mb-2">📖</p>
        <p class="text-gray-400 text-sm">Belum ada renungan.</p>
        <a href="{{ route('gembala.renungan') }}"
           class="text-indigo-600 text-sm font-medium hover:text-indigo-800">Tulis sekarang →</a>
    </div>
    @endif
</div>

{{-- Menu Cepat --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="{{ route('gembala.renungan') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition text-center">
        <p class="text-3xl mb-2">📖</p>
        <p class="font-semibold text-gray-700 text-sm">Renungan</p>
    </a>
    <a href="{{ route('gembala.pengumuman') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition text-center">
        <p class="text-3xl mb-2">📢</p>
        <p class="font-semibold text-gray-700 text-sm">Pengumuman</p>
    </a>
    <a href="{{ route('gembala.jadwal') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition text-center">
        <p class="text-3xl mb-2">📅</p>
        <p class="font-semibold text-gray-700 text-sm">Jadwal</p>
    </a>
    <a href="{{ route('gembala.profil') }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-200 transition text-center">
        <p class="text-3xl mb-2">👤</p>
        <p class="font-semibold text-gray-700 text-sm">Profil</p>
    </a>
</div>

@endsection