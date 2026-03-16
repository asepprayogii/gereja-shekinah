@extends('layouts.gembala')
@section('title', 'Kelola Renungan')

@section('content')

{{-- Header dengan Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="md:col-span-3">
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 text-xs font-medium uppercase tracking-wider">Renungan Harian</p>
                    <h1 class="text-xl font-bold">Kelola Renungan</h1>
                    <p class="text-indigo-100 text-sm mt-1">Tulis dan kelola renungan untuk jemaat</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Stat Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h8v4H7v-4z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Renungan</p>
            <p class="text-xl font-bold text-gray-800">{{ isset($renungans) ? $renungans->total() : 0 }}</p>
        </div>
    </div>
</div>

{{-- Form Tulis Renungan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    {{-- Header Form --}}
    <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-indigo-100 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Tulis Renungan Baru</h3>
        </div>
    </div>
    
    {{-- Form Content --}}
    <div class="p-6">
        <form action="{{ route('gembala.renungan.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Judul & Ayat --}}
                <div class="lg:col-span-1 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            Judul Renungan <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
                               placeholder="Masukkan judul renungan...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Ayat Alkitab
                        </label>
                        <input type="text" name="ayat" value="{{ old('ayat') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
                               placeholder="Contoh: Yohanes 3:16">
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
                
                {{-- Kolom Kanan: Isi Renungan --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                        Isi Renungan <span class="text-red-400">*</span>
                    </label>
                    <textarea name="isi" rows="8"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
                              placeholder="Tulis isi renungan di sini...">{{ old('isi') }}</textarea>
                </div>
            </div>
            
            {{-- Tombol Submit --}}
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Renungan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Renungan --}}
@if(isset($renungans) && $renungans->count() > 0)
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
                <h3 class="font-semibold text-gray-800">Daftar Renungan</h3>
            </div>
            <span class="text-xs text-gray-400">Total: {{ $renungans->total() }} renungan</span>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-6">
        <div class="space-y-3">
            @foreach($renungans as $r)
            <div class="group border border-gray-100 rounded-xl p-4 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                    {{-- Tanggal Badge --}}
                    <div class="flex sm:flex-col items-center sm:items-center gap-2 sm:gap-0 sm:w-16 sm:text-center flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-indigo-50 flex flex-col items-center justify-center">
                            <span class="text-sm sm:text-base font-bold text-indigo-700">{{ $r->tanggal_publish->format('d') }}</span>
                            <span class="text-[8px] sm:text-[10px] text-indigo-500 uppercase">{{ $r->tanggal_publish->format('M') }}</span>
                        </div>
                        <span class="text-[10px] text-gray-400 sm:mt-1">{{ $r->tanggal_publish->format('Y') }}</span>
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-800 text-base">{{ $r->judul }}</h4>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $r->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $r->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        
                        @if($r->ayat)
                        <p class="text-xs text-indigo-600 font-medium mb-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $r->ayat }}
                        </p>
                        @endif
                        
                        <p class="text-sm text-gray-600 line-clamp-2">{{ strip_tags($r->isi) }}</p>
                        
                        <div class="flex items-center gap-3 mt-3">
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $r->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex sm:flex-col items-center gap-2 sm:gap-2 sm:w-20 flex-shrink-0">
                        <a href="{{ route('gembala.renungan.edit', $r->id) }}" 
                           class="flex-1 sm:flex-none w-full sm:w-auto px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('gembala.renungan.destroy', $r->id) }}" method="POST" class="flex-1 sm:flex-none w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Hapus renungan ini?')"
                                    class="w-full sm:w-auto px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition flex items-center justify-center gap-1">
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
        @if(method_exists($renungans, 'links'))
        <div class="mt-6">
            {{ $renungans->links() }}
        </div>
        @endif
    </div>
</div>
@endif

@endsection