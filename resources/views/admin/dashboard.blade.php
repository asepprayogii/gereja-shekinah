@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Selamat Datang --}}
<div class="bg-gradient-to-r from-blue-700 to-blue-900 rounded-2xl p-5 sm:p-6 mb-6 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs><pattern id="g" width="10" height="10" patternUnits="userSpaceOnUse">
                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern></defs>
            <rect width="100" height="100" fill="url(#g)"/>
        </svg>
    </div>
    <div class="relative flex items-center justify-between">
        <div>
            <p class="text-blue-200 text-xs sm:text-sm mb-1">Selamat datang kembali</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ auth()->user()->name }}</h2>
            <p class="text-blue-200 text-xs sm:text-sm mt-1">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <div class="hidden md:flex w-14 h-14 rounded-2xl bg-white/10 items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-white/60" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
            </svg>
        </div>
    </div>
</div>

{{-- Alert Tukar Jadwal Pending --}}
@if($tukarPending > 0)
<div class="bg-orange-50 border border-orange-200 rounded-xl px-4 py-3 mb-6 flex items-center justify-between gap-3">
    <div class="flex items-center gap-2 min-w-0">
        <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-orange-700 text-sm font-medium truncate">
            <strong>{{ $tukarPending }}</strong> request tukar jadwal menunggu persetujuan
        </p>
    </div>
    <a href="{{ route('admin.tukar-jadwal') }}"
       class="text-orange-700 hover:text-orange-900 text-xs font-semibold border border-orange-200 px-3 py-1.5 rounded-lg hover:bg-orange-100 transition flex-shrink-0">
        Lihat
    </a>
</div>
@endif

{{-- Statistik Utama --}}
<div class="grid grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @php
    $stats = [
        ['route'=>'admin.jemaat',    'value'=>$totalJemaat,    'label'=>'Jemaat',     'color'=>'blue',   'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['route'=>'admin.pengguna',  'value'=>$totalPelayan,   'label'=>'Pelayan',    'color'=>'indigo', 'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['route'=>'admin.renungan',  'value'=>$totalRenungan,  'label'=>'Renungan',   'color'=>'green',  'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['route'=>'admin.pengumuman','value'=>$totalPengumuman,'label'=>'Pengumuman', 'color'=>'yellow', 'icon'=>'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
        ['route'=>'admin.galeri',    'value'=>$totalGaleri,    'label'=>'Galeri',     'color'=>'pink',   'icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route'=>'admin.musik',     'value'=>$totalMusik,     'label'=>'Lagu',       'color'=>'purple', 'icon'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
    ];
    $colorMap = [
        'blue'   => ['text'=>'text-blue-700',   'bg'=>'bg-blue-50',   'border'=>'hover:border-blue-200'],
        'indigo' => ['text'=>'text-indigo-600',  'bg'=>'bg-indigo-50', 'border'=>'hover:border-indigo-200'],
        'green'  => ['text'=>'text-green-600',   'bg'=>'bg-green-50',  'border'=>'hover:border-green-200'],
        'yellow' => ['text'=>'text-yellow-600',  'bg'=>'bg-yellow-50', 'border'=>'hover:border-yellow-200'],
        'pink'   => ['text'=>'text-pink-600',    'bg'=>'bg-pink-50',   'border'=>'hover:border-pink-200'],
        'purple' => ['text'=>'text-purple-600',  'bg'=>'bg-purple-50', 'border'=>'hover:border-purple-200'],
    ];
    @endphp

    @foreach($stats as $s)
    @php $c = $colorMap[$s['color']]; @endphp
    <a href="{{ route($s['route']) }}"
       class="bg-white rounded-xl border border-gray-100 shadow-sm p-3 sm:p-4 text-center hover:shadow-md {{ $c['border'] }} transition group">
        <div class="w-8 h-8 rounded-lg {{ $c['bg'] }} flex items-center justify-center mx-auto mb-2">
            <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $s['icon'] }}"/>
            </svg>
        </div>
        <p class="text-xl sm:text-2xl font-bold {{ $c['text'] }}">{{ $s['value'] }}</p>
        <p class="text-[10px] sm:text-xs text-gray-500 mt-0.5 leading-tight">{{ $s['label'] }}</p>
    </a>
    @endforeach
</div>

{{-- Baris Tengah: Kegiatan + Ultah --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">

    {{-- Kegiatan Minggu Ini --}}
    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="font-bold text-gray-800 text-sm">Kegiatan Minggu Ini</h3>
            </div>
            <a href="{{ route('admin.kalender') }}"
               class="text-xs text-blue-600 hover:text-blue-800 font-medium">Kelola</a>
        </div>

        @if($kegiatanMingguIni->count() > 0)
        <div class="space-y-1.5">
            @foreach($kegiatanMingguIni as $k)
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition">
                <div class="w-1.5 h-8 rounded-full flex-shrink-0" style="background-color: {{ $k->warna }}"></div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $k->nama_kegiatan }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $k->tanggal->translatedFormat('l') }} · {{ substr($k->jam_mulai, 0, 5) }} WIB
                    </p>
                </div>
                @if($k->tanggal->isToday())
                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-[10px] font-semibold flex-shrink-0">
                    Hari ini
                </span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm">Belum ada kegiatan minggu ini.</p>
            <a href="{{ route('admin.kalender') }}" class="text-blue-600 text-xs font-medium hover:text-blue-800">
                Tambah kegiatan
            </a>
        </div>
        @endif
    </div>

    {{-- Ulang Tahun --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-pink-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.752 1.752 0 013 15.546V12a9 9 0 0118 0v3.546zM12 6V3m-3 3l1.5-2.5M15 6l-1.5-2.5"/>
                </svg>
                <h3 class="font-bold text-gray-800 text-sm">Ultah Minggu Ini</h3>
            </div>
            <a href="{{ route('admin.jemaat') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Jemaat</a>
        </div>

        @if($ultah->count() > 0)
        <div class="space-y-2.5">
            @foreach($ultah as $j)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $j->nama_lengkap }}</p>
                    <p class="text-xs text-pink-400">{{ $j->tanggal_lahir->translatedFormat('d F') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.752 1.752 0 013 15.546V12a9 9 0 0118 0v3.546zM12 6V3m-3 3l1.5-2.5M15 6l-1.5-2.5"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm">Tidak ada yang berulang tahun.</p>
        </div>
        @endif
    </div>
</div>

{{-- Baris Bawah: Renungan + Jemaat Baru --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

    {{-- Renungan Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="font-bold text-gray-800 text-sm">Renungan Terbaru</h3>
            </div>
            <a href="{{ route('admin.renungan') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Kelola</a>
        </div>

        @if($renunganTerbaru->count() > 0)
        <div class="space-y-3">
            @foreach($renunganTerbaru as $r)
            <div class="flex items-start justify-between gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $r->judul }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $r->tanggal_publish->translatedFormat('d F Y') }} · {{ $r->penulis->name ?? '-' }}
                    </p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0
                    {{ $r->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $r->is_published ? 'Publish' : 'Draft' }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-400 text-sm">Belum ada renungan.</p>
        </div>
        @endif
    </div>

    {{-- Jemaat Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="font-bold text-gray-800 text-sm">Jemaat Terbaru</h3>
            </div>
            <a href="{{ route('admin.jemaat') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Kelola</a>
        </div>

        @if($jemaatTerbaru->count() > 0)
        <div class="space-y-3">
            @foreach($jemaatTerbaru as $j)
            <div class="flex items-center gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $j->nama_lengkap }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $j->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0
                    {{ $j->status_aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $j->status_aktif ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-400 text-sm">Belum ada data jemaat.</p>
        </div>
        @endif
    </div>

</div>

@endsection