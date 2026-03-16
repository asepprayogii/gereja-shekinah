@extends('layouts.gembala')
@section('title', 'Kelola Pengumuman')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3 rounded-r-lg mb-6 text-sm flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- Header dengan Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="md:col-span-3">
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 text-xs font-medium uppercase tracking-wider">Pengumuman Gereja</p>
                    <h1 class="text-xl font-bold">Kelola Pengumuman</h1>
                    <p class="text-indigo-100 text-sm mt-1">Buat dan kelola pengumuman untuk jemaat</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Stat Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Pengumuman</p>
            <p class="text-xl font-bold text-gray-800">{{ $pengumuman->total() ?? 0 }}</p>
        </div>
    </div>
</div>

{{-- Form Tulis Pengumuman --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    {{-- Header Form --}}
    <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-indigo-100 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Tulis Pengumuman Baru</h3>
        </div>
    </div>
    
    {{-- Form Content --}}
    <div class="p-6">
        <form action="{{ route('gembala.pengumuman.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Judul & Tanggal --}}
                <div class="lg:col-span-1 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            Judul Pengumuman <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
                               placeholder="Masukkan judul pengumuman...">
                        @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                            <input type="date" name="tanggal_publish" value="{{ old('tanggal_publish', date('Y-m-d')) }}"
                                   class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>
                        <div class="flex items-end pb-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="w-4 h-4 text-indigo-600 rounded border-gray-300">
                                <span class="text-sm text-gray-700">Langsung publish</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                {{-- Kolom Kanan: Isi Pengumuman --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                        Isi Pengumuman <span class="text-red-400">*</span>
                    </label>
                    <textarea name="isi" rows="6"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
                              placeholder="Tulis isi pengumuman di sini...">{{ old('isi') }}</textarea>
                    @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            
            {{-- Tombol Submit --}}
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Pengumuman --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800">Daftar Pengumuman</h3>
            </div>
            <span class="text-xs text-gray-400">Total: {{ $pengumuman->total() }} pengumuman</span>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-6">
        @if($pengumuman->count() > 0)
        <div class="space-y-4">
            @foreach($pengumuman as $p)
            <div class="group border border-gray-100 rounded-xl p-5 hover:border-indigo-200 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                    {{-- Tanggal Badge --}}
                    <div class="flex sm:flex-col items-center sm:items-center gap-2 sm:gap-0 sm:w-16 sm:text-center flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-indigo-50 flex flex-col items-center justify-center">
                            <span class="text-lg sm:text-xl font-bold text-indigo-700">{{ $p->tanggal_publish->format('d') }}</span>
                            <span class="text-[10px] sm:text-xs text-indigo-500 uppercase">{{ $p->tanggal_publish->format('M') }}</span>
                        </div>
                        <span class="text-[10px] text-gray-400 sm:mt-1">{{ $p->tanggal_publish->format('Y') }}</span>
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h4 class="font-semibold text-gray-800 text-base sm:text-lg">{{ $p->judul }}</h4>
                            <span class="text-xs px-2 py-1 rounded-full flex items-center gap-1
                                {{ $p->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->is_published ? 'bg-green-600' : 'bg-yellow-600' }}"></span>
                                {{ $p->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ Str::limit(strip_tags($p->isi), 200) }}
                        </p>
                        
                        <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $p->created_at->diffForHumans() }}
                            </span>
                            @if($p->updated_at != $p->created_at)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Diperbarui
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex sm:flex-col items-center gap-2 sm:gap-2 sm:w-20 flex-shrink-0">
                        <a href="{{ route('gembala.pengumuman.edit', $p->id) }}" 
                           class="flex-1 sm:flex-none w-full sm:w-auto px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('gembala.pengumuman.destroy', $p->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')"
                              class="flex-1 sm:flex-none w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full sm:w-auto px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pengumuman->links() }}
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada pengumuman</p>
            <p class="text-xs text-gray-400 mt-1">Mulai buat pengumuman pertama Anda</p>
        </div>
        @endif
    </div>
</div>

@endsection