@extends('layouts.admin')
@section('title', 'About & Sosial Media')

@section('content')

@if(session('success'))
<div class="mb-6 animate-fade-in">
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
@endif

{{-- Header dengan Statistik --}}
<div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">
    <div class="lg:col-span-3">
        <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                              d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Profil Gereja</p>
                    <h1 class="text-2xl font-bold">Informasi & Sosial Media</h1>
                    <p class="text-blue-100 text-sm mt-1">Kelola informasi gereja dan tautan media sosial</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Stat Cards --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Info Terisi</p>
            <p class="text-xl font-bold text-gray-800">
                @php
                    $filled = 0;
                    if($about->nama_gereja) $filled++;
                    if($about->alamat) $filled++;
                    if($about->sejarah) $filled++;
                    if($about->visi) $filled++;
                    if($about->misi) $filled++;
                @endphp
                {{ $filled }}/5
            </p>
        </div>
    </div>
</div>

{{-- Navigation Tabs --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 inline-flex mb-6">
    <button onclick="switchTab('informasi')" id="tab-informasi-btn" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-all tab-btn active bg-blue-700 text-white">
        Informasi Dasar
    </button>
    <button onclick="switchTab('visimisi')" id="tab-visimisi-btn" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-all tab-btn text-gray-600 hover:text-gray-900">
        Visi & Misi
    </button>
    <button onclick="switchTab('sosmed')" id="tab-sosmed-btn" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-all tab-btn text-gray-600 hover:text-gray-900">
        Sosial Media
    </button>
    <button onclick="switchTab('maps')" id="tab-maps-btn" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-all tab-btn text-gray-600 hover:text-gray-900">
        Google Maps
    </button>
</div>

{{-- Form Utama --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <form action="{{ route('admin.about.update') }}" method="POST" id="mainForm">
        @csrf
        
        {{-- Tabs Content --}}
        <div class="p-6">
            {{-- Tab 1: Informasi Dasar --}}
            <div id="tab-informasi" class="tab-content">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Informasi Dasar Gereja</h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Gereja <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="nama_gereja" value="{{ $about->nama_gereja }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition"
                               placeholder="GPdI Shekinah...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No Telepon</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input type="text" name="no_telp" value="{{ $about->no_telp }}"
                                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition"
                                  placeholder="Jl. Contoh No. 123, Kota">{{ $about->alamat }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sejarah Singkat</label>
                        <textarea name="sejarah" rows="4"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition"
                                  placeholder="Sejarah berdirinya gereja...">{{ $about->sejarah }}</textarea>
                    </div>
                </div>
            </div>
            
            {{-- Tab 2: Visi & Misi --}}
            <div id="tab-visimisi" class="tab-content hidden">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Visi & Misi Gereja</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50/30 rounded-xl p-5 border border-blue-100/50">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-800">Visi</h4>
                        </div>
                        <textarea name="visi" rows="4"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition bg-white"
                                  placeholder="Visi gereja...">{{ $about->visi }}</textarea>
                    </div>
                    
                    <div class="bg-purple-50/30 rounded-xl p-5 border border-purple-100/50">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-800">Misi</h4>
                        </div>
                        <textarea name="misi" rows="4"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition bg-white"
                                  placeholder="Misi gereja...">{{ $about->misi }}</textarea>
                    </div>
                </div>
            </div>
            
            {{-- Tab 3: Sosial Media --}}
            <div id="tab-sosmed" class="tab-content hidden">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Sosial Media Gereja</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-600 mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="1.5"/>
                                <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
                                <circle cx="12" cy="12" r="4" stroke-width="1.5"/>
                            </svg>
                            Instagram
                        </label>
                        <input type="url" name="instagram" value="{{ $about->instagram }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition group-hover:border-pink-200"
                               placeholder="https://instagram.com/...">
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-600 mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33z"/>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="currentColor"/>
                            </svg>
                            YouTube
                        </label>
                        <input type="url" name="youtube" value="{{ $about->youtube }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-300 transition group-hover:border-red-200"
                               placeholder="https://youtube.com/...">
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-600 mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                            Facebook
                        </label>
                        <input type="url" name="facebook" value="{{ $about->facebook }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition group-hover:border-blue-200"
                               placeholder="https://facebook.com/...">
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-600 mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M22 4.01c-1 .49-1.98.689-3 .99-1.21-1.47-3.08-1.51-4.68-.97-1.53.52-2.64 1.89-2.76 3.5a5.03 5.03 0 01-2.23-1.06c-1.63-1.34-3.64-2.19-5.81-2.44-.84 1.59-.37 3.45.99 4.57-.86.03-1.69-.25-2.4-.64v.05c0 1.82 1.07 3.46 2.71 4.02-.64.17-1.31.2-1.97.08.58 1.8 2.22 3.04 4.1 3.08-1.56 1.22-3.47 1.86-5.45 1.82 5.09 3.24 11.3 2.12 14.07-2.42 1.82-2.98 2.02-7.2.54-10.04 1.04-.78 1.86-1.76 2.43-2.92l.04-.03z"/>
                            </svg>
                            TikTok
                        </label>
                        <input type="url" name="tiktok" value="{{ $about->tiktok }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-300 transition group-hover:border-gray-200"
                               placeholder="https://tiktok.com/...">
                    </div>
                </div>
            </div>
            
            {{-- Tab 4: Google Maps --}}
            <div id="tab-maps" class="tab-content hidden">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Google Maps</h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Embed Code Google Maps
                        </label>
                        <textarea name="maps_embed" rows="4"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 transition"
                                  placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'>{{ $about->maps_embed }}</textarea>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Buka Google Maps → Share → Embed a map → Copy HTML
                            </span>
                        </p>
                    </div>
                    
                    @if($about->maps_embed)
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-medium text-gray-600">Preview Maps</span>
                        </div>
                        <div class="h-64">
                            {!! $about->maps_embed !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Footer dengan tombol simpan --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <div class="text-xs text-gray-400">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Data aman & tersimpan
                </span>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Show selected tab content
    document.getElementById(`tab-${tabName}`).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-700', 'text-white');
        btn.classList.add('text-gray-600', 'hover:text-gray-900');
    });
    
    // Style active button
    const activeBtn = document.getElementById(`tab-${tabName}-btn`);
    activeBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
    activeBtn.classList.add('bg-blue-700', 'text-white');
}

// Initialize first tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('informasi');
});
</script>
@endpush

@push('styles')
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.tab-btn {
    transition: all 0.2s ease;
}

.tab-content {
    transition: opacity 0.2s ease;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}
.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}
.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush

@endsection