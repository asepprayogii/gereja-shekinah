@extends('layouts.admin')
@section('title', 'Kelola Musik Pujian')

@section('content')

{{-- Toolbar: Search + Tambah --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.musik') }}" class="flex-1 flex gap-2">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul atau penyanyi..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
        <button type="submit"
                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition flex-shrink-0">
            Cari
        </button>
    </form>
    <button onclick="toggleForm()"
            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition flex-shrink-0">
        <svg id="btn-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="hidden sm:inline">Tambah Lagu</span>
    </button>
</div>

{{-- Form Tambah (tersembunyi default) --}}
<div id="form-tambah" class="hidden mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4 sm:p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Tambah Lagu Baru</h3>
        </div>
        <form action="{{ route('admin.musik.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Lagu <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_lagu" value="{{ old('judul_lagu') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Judul lagu...">
                    @error('judul_lagu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Penyanyi / Artis</label>
                    <input type="text" name="penyanyi" value="{{ old('penyanyi') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Nama penyanyi...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Link YouTube <span class="text-red-500">*</span></label>
                    <input type="url" name="link_youtube" value="{{ old('link_youtube') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="https://youtube.com/watch?v=...">
                    @error('link_youtube')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-gray-100">
                <button type="button" onclick="toggleForm()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Grid Lagu --}}
@if($musik->count() > 0)

{{-- Info hasil pencarian --}}
@if(request('search'))
<div class="flex items-center justify-between mb-3">
    <p class="text-sm text-gray-500">
        Hasil pencarian <span class="font-semibold text-gray-700">"{{ request('search') }}"</span>
        — {{ $musik->count() }} lagu ditemukan
    </p>
    <a href="{{ route('admin.musik') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
        Hapus filter
    </a>
</div>
@else
<p class="text-xs text-gray-400 mb-3">{{ $musik->count() }} lagu tersedia</p>
@endif

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
    @foreach($musik as $m)
    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:border-gray-200 transition group">
        {{-- Thumbnail --}}
        <div class="relative">
            <img src="https://img.youtube.com/vi/{{ $m->video_id }}/hqdefault.jpg"
                 alt="{{ $m->judul_lagu }}"
                 class="w-full h-28 sm:h-32 object-cover group-hover:scale-105 transition duration-300">
            {{-- Play overlay --}}
            <a href="{{ $m->link_youtube }}" target="_blank"
               class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/30 transition duration-300">
                <div class="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg">
                    <svg class="w-4 h-4 text-red-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
            </a>
        </div>

        {{-- Info --}}
        <div class="p-3">
            <p class="font-semibold text-gray-800 text-sm line-clamp-1 leading-tight">{{ $m->judul_lagu }}</p>
            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $m->penyanyi ?: '—' }}</p>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-50">
                <a href="{{ $m->link_youtube }}" target="_blank"
                   class="flex items-center gap-1 text-[10px] text-red-500 hover:text-red-700 font-medium transition">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.26 8.26 0 004.84 1.56V6.79a4.85 4.85 0 01-1.07-.1z"/>
                    </svg>
                    YouTube
                </a>
                <form action="{{ route('admin.musik.destroy', $m->id) }}" method="POST"
                      onsubmit="return confirm('Hapus {{ addslashes($m->judul_lagu) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-7 h-7 flex items-center justify-center rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
        </svg>
    </div>
    @if(request('search'))
        <p class="text-gray-500 font-medium text-sm">Tidak ada lagu yang cocok.</p>
        <a href="{{ route('admin.musik') }}" class="text-blue-600 text-xs font-medium hover:text-blue-800 mt-1 inline-block">Lihat semua lagu</a>
    @else
        <p class="text-gray-500 font-medium text-sm">Belum ada lagu.</p>
        <p class="text-gray-400 text-xs mt-1">Klik Tambah Lagu untuk memulai.</p>
    @endif
</div>
@endif

@push('scripts')
<script>
function toggleForm() {
    const form  = document.getElementById('form-tambah');
    const icon  = document.getElementById('btn-icon');
    const shown = !form.classList.contains('hidden');

    if (shown) {
        form.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    } else {
        form.classList.remove('hidden');
        icon.style.transform = 'rotate(45deg)';
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Buka form otomatis jika ada error validasi
@if($errors->any())
document.addEventListener('DOMContentLoaded', () => toggleForm());
@endif
</script>
@endpush

@endsection