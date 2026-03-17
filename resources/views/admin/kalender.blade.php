@extends('layouts.admin')
@section('title', 'Kalender Kegiatan')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-600/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            Kalender Kegiatan
        </h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola jadwal ibadah rutin dan kegiatan khusus gereja</p>
    </div>
    {{-- Quick Stats --}}
    <div class="flex items-center gap-3">
        <div class="px-4 py-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="text-2xl font-bold text-blue-600">{{ $kegiatanMingguIni->count() }}</span>
            <span class="text-xs text-gray-500 ml-1">Minggu Ini</span>
        </div>
        <div class="px-4 py-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="text-2xl font-bold text-green-600">{{ $templates->where('is_active', true)->count() }}</span>
            <span class="text-xs text-gray-500 ml-1">Tampil Publik</span>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div id="flash-message" class="fixed top-4 right-4 z-50 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-3.5 rounded-xl shadow-lg shadow-green-500/30 flex items-center gap-3 animate-slide-in">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
    <button onclick="document.getElementById('flash-message').remove()" class="ml-2 text-white/80 hover:text-white transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

@if($errors->any())
<div id="error-message" class="fixed top-4 right-4 z-50 bg-gradient-to-r from-red-500 to-rose-600 text-white px-5 py-3.5 rounded-xl shadow-lg shadow-red-500/30 flex items-center gap-3 animate-slide-in">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium text-sm">{{ $errors->first() }}</span>
    <button onclick="document.getElementById('error-message').remove()" class="ml-2 text-white/80 hover:text-white transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- Info Banner - Explaining the System --}}
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-4 mb-6">
    <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 text-sm">Cara Kerja Sistem Kalender</h4>
            <ul class="mt-2 space-y-1 text-xs text-blue-800">
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span><strong>Template Rutin:</strong> Jadwal berulang otomatis (Ibadah Minggu, Doa Rabu, dll) yang setiap minggu masuk ke "Minggu Ini"</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span><strong>Toggle Tampil Publik:</strong> Aktif = muncul di beranda publik, Nonaktif = hanya internal admin</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span><strong>Kegiatan Khusus:</strong> Event satu kali seperti Natal, Paskah, Kemah, dll (di luar jadwal rutin)</span>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Modern Tabs Navigation --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 overflow-hidden">
    <div class="flex border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white overflow-x-auto scrollbar-hide">
        <button onclick="switchTab('template')" id="tab-template"
                class="flex-1 sm:flex-none px-4 sm:px-6 py-4 text-sm font-semibold text-blue-700 bg-white border-b-2 border-blue-600 transition-all duration-200 flex items-center justify-center gap-2 hover:bg-blue-50/50 whitespace-nowrap">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
            </svg>
            <span class="hidden sm:inline">Template Rutin</span>
            <span class="sm:hidden">Template</span>
        </button>
        <button onclick="switchTab('kegiatan')" id="tab-kegiatan"
                class="flex-1 sm:flex-none px-4 sm:px-6 py-4 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-all duration-200 flex items-center justify-center gap-2 hover:bg-gray-50 whitespace-nowrap">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="hidden sm:inline">Minggu Ini</span>
            <span class="sm:hidden">Minggu Ini</span>
            @if($kegiatanMingguIni->where(fn($k) => $k->tanggal->isToday())->count() > 0)
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            @endif
        </button>
        <button onclick="switchTab('khusus')" id="tab-khusus"
                class="flex-1 sm:flex-none px-4 sm:px-6 py-4 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-all duration-200 flex items-center justify-center gap-2 hover:bg-gray-50 whitespace-nowrap">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            <span class="hidden sm:inline">Kegiatan Khusus</span>
            <span class="sm:hidden">Khusus</span>
        </button>
    </div>
</div>

{{-- TAB 1: TEMPLATE RUTIN --}}
<div id="content-template" class="tab-content space-y-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                        Template Jadwal Rutin
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Jadwal berulang otomatis setiap minggu (Ibadah, Doa, Sekolah Minggu, dll)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                        {{ $templates->where('is_active', true)->count() }} Tampil Publik
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                        {{ $templates->where('is_active', false)->count() }} Internal
                    </span>
                    <button onclick="openTambahTemplate()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Rutin
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80">
                    <tr class="text-gray-600 text-left">
                        <th class="px-5 py-4 font-semibold">Hari</th>
                        <th class="px-5 py-4 font-semibold">Kegiatan</th>
                        <th class="px-5 py-4 font-semibold">Jam</th>
                        <th class="px-5 py-4 font-semibold">Tampil Publik</th>
                        <th class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($templates->sortBy(fn($t) => $t->hari_id) as $t)
                    <tr class="hover:bg-blue-50/30 transition-colors {{ !$t->is_active ? 'opacity-60 bg-gray-50/30' : '' }}">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                    <span class="text-xs font-bold text-blue-700">{{ substr($t->nama_hari, 0, 3) }}</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $t->nama_hari }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900">{{ $t->nama_kegiatan }}</span>
                                @if($t->jenis && $t->jenis != 'Ibadah')
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-medium">{{ $t->jenis }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 text-gray-700 font-medium">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ substr($t->jam_mulai, 0, 5) }} WIB
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            {{-- Toggle Switch for Public Visibility --}}
                            <form action="{{ route('admin.kalender.template.toggle', $t->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <label class="relative inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_active" value="1" {{ $t->is_active ? 'checked' : '' }} 
                                           class="sr-only peer" onchange="this.form.submit()">
                                    <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-xs font-medium {{ $t->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $t->is_active ? 'Ya' : 'Tidak' }}
                                    </span>
                                </label>
                            </form>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditTemplate({{ $t->id }}, '{{ addslashes($t->nama_kegiatan) }}', '{{ substr($t->jam_mulai,0,5) }}', '{{ $t->lokasi ?? '' }}')"
                                        class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.kalender.template.destroy', $t->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus template \'{{ addslashes($t->nama_kegiatan) }}\' ? Kegiatan rutin ini tidak akan muncul lagi.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada template jadwal rutin</p>
                                <p class="text-xs text-gray-400 mt-1 mb-4">Tambahkan jadwal berulang seperti Ibadah Minggu, Doa Rabu, dll</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- TAB 2: KEGIATAN MINGGU INI (Auto-Generated from Templates + Special Events) --}}
<div id="content-kegiatan" class="tab-content hidden space-y-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50/50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Kegiatan Minggu Ini
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        <span class="font-medium text-gray-700">{{ $weekStart->translatedFormat('d M') }}</span>
                        -
                        <span class="font-medium text-gray-700">{{ $weekEnd->translatedFormat('d M Y') }}</span>
                        <span class="text-gray-400 mx-2">•</span>
                        <span class="text-gray-500">Senin - Minggu</span>
                    </p>
                </div>
                <button onclick="window.location.reload()"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            @if($kegiatanMingguIni->count() > 0)
            {{-- Week Days Navigator (Senin-Minggu) --}}
            <div class="flex gap-2 overflow-x-auto pb-3 mb-4 scrollbar-hide" id="week-days-header">
                @php
                    $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                    $current = $weekStart->copy();
                @endphp
                @for($i = 0; $i < 7; $i++)
                    @php
                        $isToday = $current->isToday();
                        $hasActivity = $kegiatanMingguIni->contains('tanggal', $current->format('Y-m-d'));
                    @endphp
                    <button class="flex-shrink-0 w-14 py-2 rounded-xl text-center transition-all
                        {{ $isToday ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}
                        {{ $hasActivity && !$isToday ? 'ring-2 ring-blue-200' : '' }}"
                        onclick="scrollToDay('{{ $current->format('Y-m-d') }}')">
                        <div class="text-[10px] font-medium uppercase tracking-wide">{{ $days[$i] }}</div>
                        <div class="text-lg font-bold leading-none mt-0.5">{{ $current->format('d') }}</div>
                        @if($hasActivity && !$isToday)
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mx-auto mt-1"></div>
                        @endif
                    </button>
                    @php $current->addDay(); @endphp
                @endfor
            </div>

            {{-- Activities List - Grouped by Day (Senin-Minggu) --}}
            <div class="space-y-4" id="activities-list">
                @php
                    $grouped = $kegiatanMingguIni->groupBy(fn($k) => $k->tanggal->format('Y-m-d'));
                    $dayNames = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                    $sortedDates = collect($grouped->keys())->sortBy(fn($date) => \Carbon\Carbon::parse($date)->dayOfWeekIso)->all();
                @endphp
                
                @foreach($sortedDates as $date)
                    @php
                        $activities = $grouped->get($date);
                        $carbonDate = \Carbon\Carbon::parse($date);
                        $dayName = $dayNames[$carbonDate->dayOfWeekIso - 1];
                        $isToday = $carbonDate->isToday();
                    @endphp
                    
                    {{-- Day Section Header --}}
                    <div id="day-{{ $date }}" class="scroll-mt-4">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $isToday ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : 'bg-gray-100' }} text-white">
                                <div class="text-center">
                                    <div class="text-[10px] font-medium uppercase">{{ substr($dayName, 0, 3) }}</div>
                                    <div class="text-base font-bold leading-none">{{ $carbonDate->format('d') }}</div>
                                </div>
                            </div>
                            @if($isToday)
                                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Hari Ini</span>
                            @endif
                        </div>

                        {{-- Activities for this day --}}
                        <div class="space-y-3 pl-2">
                            @foreach($activities->sortBy('jam_mulai') as $k)
                            @php
                                $isPast = $k->tanggal->isPast() || ($k->tanggal->isToday() && \Carbon\Carbon::parse($k->jam_mulai)->isPast());
                                $isSpecial = $k->jenis_khusus ?? false;
                            @endphp
                            <div class="bg-white border border-gray-100 rounded-xl p-4 hover:border-gray-200 hover:shadow-sm transition-all {{ $isPast ? 'opacity-75' : '' }} {{ $isSpecial ? 'border-l-4 border-l-amber-400' : '' }}">
                                <div class="flex items-start gap-3">
                                    {{-- Time Badge --}}
                                    <div class="flex-shrink-0">
                                        <div class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-center min-w-[64px]">
                                            <div class="text-sm font-bold">{{ substr($k->jam_mulai, 0, 5) }}</div>
                                            <div class="text-[10px] text-blue-500 uppercase">WIB</div>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h4 class="font-semibold text-gray-900 text-sm">{{ $k->nama_kegiatan }}</h4>
                                            @if($isSpecial)
                                                <span class="text-[10px] font-medium bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">
                                                    <svg class="w-3 h-3 inline -mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    Khusus
                                                </span>
                                            @endif
                                            @if($isPast)
                                                <span class="text-[10px] font-medium bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full">Selesai</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-wrap items-center gap-3 mt-2">
                                            @if($k->lokasi)
                                            <span class="flex items-center gap-1.5 text-xs text-gray-500">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="truncate max-w-[150px] sm:max-w-none">{{ $k->lokasi }}</span>
                                            </span>
                                            @else
                                            <span class="text-xs text-orange-500 font-medium">⚠ Lokasi belum diisi</span>
                                            @endif
                                        </div>
                                        @if($k->keterangan)
                                            <p class="text-xs text-gray-500 mt-2 line-clamp-1">{{ $k->keterangan }}</p>
                                        @endif
                                    </div>

                                    {{-- Edit/Delete Buttons --}}
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <a href="{{ route('admin.kalender.edit', $k->id) }}"
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.kalender.destroy', $k->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kegiatan \'{{ addslashes($k->nama_kegiatan) }}\' ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium">Tidak ada kegiatan minggu ini</p>
                <p class="text-xs text-gray-400 mt-1">Aktifkan template rutin di tab "Template Rutin"</p>
                <button onclick="switchTab('template')" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Kelola Template Rutin
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- TAB 3: KEGIATAN KHUSUS (Special Events like Natal, Paskah, dll) --}}
<div id="content-khusus" class="tab-content hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-amber-50/50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Kegiatan Khusus
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Event spesial di luar jadwal rutin (Natal, Paskah, Kemah, Retreat, dll)</p>
                </div>
                <button onclick="openSpecialEventForm()"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Event
                </button>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            {{-- List of Special Events --}}
            @php
                $specialEvents = $kegiatanMingguIni->filter(fn($k) => $k->jenis_khusus ?? false)->sortBy('tanggal');
            @endphp
            
            @if($specialEvents->count() > 0)
            <div class="space-y-3">
                @foreach($specialEvents as $k)
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-100 rounded-xl p-4 hover:border-amber-200 hover:shadow-sm transition-all">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="font-semibold text-gray-900">{{ $k->nama_kegiatan }}</h4>
                                <span class="text-[10px] font-medium bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Event Khusus</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-4 mt-2">
                                <span class="flex items-center gap-1.5 text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $k->tanggal->translatedFormat('l, d F Y') }}
                                </span>
                                <span class="flex items-center gap-1.5 text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ substr($k->jam_mulai, 0, 5) }} WIB
                                </span>
                                @if($k->lokasi)
                                <span class="flex items-center gap-1.5 text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $k->lokasi }}
                                </span>
                                @endif
                            </div>
                            @if($k->keterangan)
                                <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $k->keterangan }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <a href="{{ route('admin.kalender.edit', $k->id) }}"
                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.kalender.destroy', $k->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus event khusus ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium">Belum ada kegiatan khusus</p>
                <p class="text-xs text-gray-400 mt-1">Tambahkan event seperti Natal, Paskah, Kemah Rohani, dll</p>
                <button onclick="openSpecialEventForm()" class="mt-4 px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 transition">
                    + Tambah Event Khusus
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Edit Template --}}
<div id="modal-edit-template" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-100">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Template Rutin
            </h3>
            <button onclick="closeModal()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="form-edit-template" method="POST" class="p-5">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="et-nama" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="et-jam-mulai" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Default</label>
                    <input type="text" name="lokasi" id="et-lokasi"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm"
                           placeholder="Gedung Utama, dll">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-lg shadow-blue-600/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tambah Kegiatan Khusus --}}
<div id="modal-special-event" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all scale-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Tambah Kegiatan Khusus
            </h3>
            <button onclick="closeSpecialEventModal()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.kalender.store') }}" method="POST" class="p-5">
            @csrf
            <input type="hidden" name="jenis_khusus" value="1">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm"
                           placeholder="Contoh: Kebaktian Natal, Perayaan Paskah...">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm"
                           placeholder="Contoh: Gedung Utama...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 text-sm resize-none"
                              placeholder="Deskripsi event, catatan khusus..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeSpecialEventModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl transition shadow-lg shadow-amber-600/25">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>


{{-- Modal Tambah Template Rutin --}}
<div id="modal-tambah-template" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal Rutin
            </h3>
            <button onclick="closeTambahTemplate()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.kalender.template.store') }}" method="POST" class="p-5">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-sm"
                           placeholder="Contoh: Ibadah Pemuda, Doa Pagi...">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Hari <span class="text-red-500">*</span></label>
                        <select name="hari_id" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-sm bg-white">
                            <option value="">Pilih Hari</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="7">Minggu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-sm"
                           placeholder="Gedung Utama, Aula, dll">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis</label>
                    <select name="jenis"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-sm bg-white">
                        <option value="Ibadah">Ibadah</option>
                        <option value="Doa">Doa</option>
                        <option value="Latihan">Latihan</option>
                        <option value="Persekutuan">Persekutuan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" checked id="tt-active"
                           class="w-4 h-4 text-blue-600 rounded border-gray-300">
                    <label for="tt-active" class="text-sm text-gray-700">Langsung tampil di publik</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeTambahTemplate()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-lg shadow-blue-600/25">
                    Simpan Template
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Styles --}}
<style>
@keyframes slide-in {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}
.animate-slide-in { animation: slide-in 0.3s ease-out; }
.animate-fade-in { animation: fade-in 0.2s ease-out; }

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.tab-content {
    transition: opacity 0.2s ease;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

@media (max-width: 640px) {
    button, [type="button"], [type="submit"], [type="reset"], a {
        min-height: 44px;
    }
    input, select, textarea {
        min-height: 48px;
        font-size: 16px;
    }
}

::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

{{-- JavaScript --}}
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
        el.style.opacity = '0';
    });
    document.querySelectorAll('[id^="tab-"]').forEach(btn => {
        btn.classList.remove('text-blue-700', 'bg-white', 'border-b-2', 'border-blue-600');
        btn.classList.add('text-gray-600', 'hover:bg-gray-50');
    });
    const content = document.getElementById('content-'+tab);
    content.classList.remove('hidden');
    setTimeout(() => { content.style.opacity = '1'; }, 10);
    const btn = document.getElementById('tab-'+tab);
    btn.classList.remove('text-gray-600', 'hover:bg-gray-50');
    btn.classList.add('text-blue-700', 'bg-white', 'border-b-2', 'border-blue-600');
    
    if (window.innerWidth < 768) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function openEditTemplate(id, nama, jam, lokasi) {
    document.getElementById('et-nama').value = nama;
    document.getElementById('et-jam-mulai').value = jam;
    document.getElementById('et-lokasi').value = lokasi || '';
    document.getElementById('form-edit-template').action = '/admin/kalender/template/' + id;
    document.getElementById('modal-edit-template').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modal-edit-template').classList.add('hidden');
    document.body.style.overflow = '';
}

function openSpecialEventForm() {
    document.getElementById('modal-special-event').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSpecialEventModal() {
    document.getElementById('modal-special-event').classList.add('hidden');
    document.body.style.overflow = '';
}

function openTambahTemplate() {
    document.getElementById('modal-tambah-template').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeTambahTemplate() {
    document.getElementById('modal-tambah-template').classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('modal-tambah-template')?.addEventListener('click', (e) => {
    if(e.target === e.currentTarget) closeTambahTemplate();
});

function scrollToDay(date) {
    const element = document.getElementById('day-' + date);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        element.classList.add('ring-2', 'ring-blue-300', 'rounded-xl');
        setTimeout(() => element.classList.remove('ring-2', 'ring-blue-300', 'rounded-xl'), 2000);
    }
}

document.getElementById('modal-edit-template')?.addEventListener('click', (e) => {
    if(e.target === e.currentTarget) closeModal();
});

document.getElementById('modal-special-event')?.addEventListener('click', (e) => {
    if(e.target === e.currentTarget) closeSpecialEventModal();
});

document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape') {
        closeModal();
        closeSpecialEventModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        document.getElementById('flash-message')?.remove();
        document.getElementById('error-message')?.remove();
    }, 5000);
});
</script>

@endsection