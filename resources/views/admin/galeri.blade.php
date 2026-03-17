@extends('layouts.admin')
@section('title', 'Kelola Galeri')

@section('content')

{{-- Toolbar: Search + Tambah --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.galeri') }}" class="flex-1 flex gap-2">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul atau kategori..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
        <button type="submit"
                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition flex-shrink-0">
            Cari
        </button>
    </form>
    <button onclick="toggleForm()"
            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition flex-shrink-0">
        <svg id="btn-icon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="hidden sm:inline">Upload Foto</span>
    </button>
</div>

{{-- Form Upload (tersembunyi default) --}}
<div id="form-tambah" class="hidden mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4 sm:p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Upload Foto Galeri</h3>
        </div>
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Foto <span class="text-red-500">*</span></label>
                    <input type="file" name="foto" accept="image/*" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul / Keterangan</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Keterangan foto...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Ibadah, Natal, Paskah...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Grid Foto --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800 text-sm">
            Foto Galeri
            <span class="text-gray-400 font-normal">({{ $galeri->total() }})</span>
        </h3>
        @if(request('search'))
        <div class="flex items-center gap-2">
            <p class="text-xs text-gray-500">
                Hasil: <span class="font-semibold text-gray-700">"{{ request('search') }}"</span>
            </p>
            <a href="{{ route('admin.galeri') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                Hapus filter
            </a>
        </div>
        @endif
    </div>

    @if($galeri->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        @foreach($galeri as $g)
        <div class="group relative overflow-hidden rounded-xl border border-gray-100 bg-gray-50">
            <img src="{{ $g->foto }}"
                 alt="{{ $g->judul }}"
                 class="w-full h-36 sm:h-40 object-cover group-hover:scale-105 transition duration-300">

            {{-- Overlay desktop (hover) --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition duration-300 hidden sm:block"></div>
            <div class="absolute inset-0 hidden sm:flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition duration-300">
                <div>
                    @if($g->kategori)
                    <span class="inline-block px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-[10px] font-medium rounded-full">
                        {{ $g->kategori }}
                    </span>
                    @endif
                </div>
                <div class="flex items-end justify-between gap-2">
                    <p class="text-white text-xs font-medium line-clamp-2 flex-1">{{ $g->judul ?? '' }}</p>
                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST"
                          onsubmit="return confirm('Hapus foto ini?')" class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-lg transition"
                                title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Mobile: badge kategori + tombol hapus --}}
            <div class="sm:hidden absolute top-2 left-2 right-2 flex items-start justify-between">
                @if($g->kategori)
                <span class="px-2 py-0.5 bg-black/40 text-white text-[10px] font-medium rounded-full backdrop-blur-sm">
                    {{ $g->kategori }}
                </span>
                @else
                <span></span>
                @endif
                <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST"
                      onsubmit="return confirm('Hapus foto ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-7 h-7 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-lg shadow transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Judul di bawah foto (mobile) --}}
            @if($g->judul)
            <div class="sm:hidden px-2 py-1.5 bg-white border-t border-gray-100">
                <p class="text-xs text-gray-600 truncate">{{ $g->judul }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $galeri->links() }}</div>

    @else
    <div class="text-center py-12">
        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        @if(request('search'))
            <p class="text-gray-400 text-sm">Tidak ada foto yang cocok.</p>
            <a href="{{ route('admin.galeri') }}" class="text-blue-600 text-xs font-medium hover:text-blue-800 mt-1 inline-block">Lihat semua foto</a>
        @else
            <p class="text-gray-400 text-sm">Belum ada foto galeri.</p>
            <p class="text-gray-400 text-xs mt-1">Klik Upload Foto untuk menambahkan.</p>
        @endif
    </div>
    @endif
</div>

@push('scripts')
<script>
function toggleForm() {
    const form = document.getElementById('form-tambah');
    const icon = document.getElementById('btn-icon');
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

@if($errors->any())
document.addEventListener('DOMContentLoaded', () => toggleForm());
@endif
</script>
@endpush

@endsection