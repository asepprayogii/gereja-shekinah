@extends('layouts.admin')
@section('title', 'Request Tukar Jadwal')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- Header Section --}}
<div class="mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Manajemen Jadwal</p>
            <h1 class="text-xl font-bold text-gray-800">🔄 Request Tukar Jadwal</h1>
        </div>
    </div>
    <p class="text-sm text-gray-500 mt-2 ml-13">
        Kelola permintaan penukaran jadwal dari pelayan. Setujui atau tolak dengan catatan.
    </p>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    
    @if($requests->count() > 0)
    
    {{-- Table Header (Desktop) --}}
    <div class="hidden md:grid grid-cols-12 px-6 py-3 bg-gray-50/80 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wide">
        <div class="col-span-5">Detail Request</div>
        <div class="col-span-3">Pemohon → Pengganti</div>
        <div class="col-span-2 text-center">Status</div>
        <div class="col-span-2 text-right">Aksi</div>
    </div>

    {{-- List Requests --}}
    <div class="divide-y divide-gray-50">
        @foreach($requests as $r)
        <div class="group hover:bg-gray-50/50 transition-colors">
            <div class="p-5 md:p-6">
                
                {{-- Mobile: Header Ringkas --}}
                <div class="md:hidden flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2">
                        {{-- Status Badge --}}
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                            {{ $r->status === 'disetujui' ? 'bg-green-100 text-green-700' :
                               ($r->status === 'ditolak' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">
                            {{ $r->status === 'menunggu' ? '⏳ Menunggu' :
                               ($r->status === 'disetujui' ? '✅ Disetujui' : '❌ Ditolak') }}
                        </span>
                        {{-- Tipe Badge --}}
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-medium
                            {{ $r->tipe === 'minggu' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' }}">
                            {{ $r->tipe === 'minggu' ? '⛪ Minggu' : '📋 Pelayanan' }}
                        </span>
                    </div>
                    <span class="text-[10px] text-gray-400">
                        {{ $r->created_at->translatedFormat('d M H:i') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6">
                    
                    {{-- Kolom 1: Detail Request --}}
                    <div class="md:col-span-5 space-y-3">
                        
                        {{-- Desktop: Status & Tipe --}}
                        <div class="hidden md:flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                {{ $r->status === 'disetujui' ? 'bg-green-100 text-green-700' :
                                   ($r->status === 'ditolak' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">
                                {{ $r->status === 'menunggu' ? '⏳ Menunggu' :
                                   ($r->status === 'disetujui' ? '✅ Disetujui' : '❌ Ditolak') }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-medium
                                {{ $r->tipe === 'minggu' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' }}">
                                {{ $r->tipe === 'minggu' ? '⛪ Ibadah Minggu' : '📋 Jadwal Pelayanan' }}
                            </span>
                            <span class="text-[10px] text-gray-400 ml-auto">
                                {{ $r->created_at->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>

                        {{-- Info Jadwal --}}
                        <div class="bg-gray-50/50 rounded-xl p-3 border border-gray-100">
                            @if($r->tipe === 'minggu' && $r->jadwalMinggu)
                                <p class="font-semibold text-gray-800 text-sm">
                                    ⛪ Ibadah Minggu
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    📅 {{ $r->jadwalMinggu->tanggal->translatedFormat('l, d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    🎯 {{ \App\Models\JadwalIbadahMinggu::$posisiList[$r->jadwalMinggu->posisi] ?? $r->jadwalMinggu->posisi }}
                                </p>
                            @elseif($r->tipe === 'pelayanan' && $r->jadwal)
                                <p class="font-semibold text-gray-800 text-sm">
                                    📋 {{ $r->jadwal->kegiatan->nama_kegiatan }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    📅 {{ $r->jadwal->kegiatan->tanggal->translatedFormat('l, d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    🎯 {{ $r->jadwal->posisi }}
                                </p>
                            @endif
                        </div>

                        {{-- Alasan --}}
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1">💬 Alasan</p>
                            <p class="text-sm text-gray-700 bg-amber-50/50 border border-amber-100 rounded-lg px-3 py-2">
                                {{ $r->alasan }}
                            </p>
                        </div>

                        {{-- Catatan Admin (jika ada) --}}
                        @if($r->catatan_admin)
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">📝 Catatan Admin</p>
                            <p class="text-sm text-gray-600 mt-1 italic">"{{ $r->catatan_admin }}"</p>
                        </div>
                        @endif
                    </div>

                    {{-- Kolom 2: Pemohon → Pengganti --}}
                    <div class="md:col-span-3 flex md:flex-col justify-between md:justify-center items-start md:items-center gap-3 py-2 md:py-0">
                        
                        {{-- Pemohon --}}
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-blue-700">
                                    {{ strtoupper(substr($r->pemohon->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase">Pemohon</p>
                                <p class="text-sm font-medium text-gray-800">{{ $r->pemohon->name }}</p>
                            </div>
                        </div>

                        {{-- Arrow --}}
                        <svg class="w-4 h-4 text-gray-300 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                        <svg class="w-4 h-4 text-gray-300 hidden md:block rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>

                        {{-- Pengganti --}}
                        @if($r->pengganti)
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-green-700">
                                    {{ strtoupper(substr($r->pengganti->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase">Pengganti</p>
                                <p class="text-sm font-medium text-gray-800">{{ $r->pengganti->name }}</p>
                            </div>
                        </div>
                        @else
                        <span class="text-xs text-gray-400 italic">Tanpa pengganti</span>
                        @endif
                    </div>

                    {{-- Kolom 3: Status (Desktop) --}}
                    <div class="md:col-span-2 hidden md:flex items-center justify-center">
                        @if($r->status === 'menunggu')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-xs font-medium border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @elseif($r->status === 'disetujui')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-xs font-medium border border-green-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-700 text-xs font-medium border border-red-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Ditolak
                            </span>
                        @endif
                    </div>

                    {{-- Kolom 4: Aksi --}}
                    <div class="md:col-span-2 flex md:flex-col items-end md:items-center justify-end gap-2">
                        @if($r->status === 'menunggu')
                            {{-- Form Approve --}}
                            <form action="{{ route('admin.tukar-jadwal.approve', $r->id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="catatan_admin"
                                       class="hidden md:block w-full border border-gray-200 rounded-lg px-3 py-1.5 text-xs mb-2 focus:outline-none focus:ring-2 focus:ring-green-300 bg-white"
                                       placeholder="Catatan...">
                                <button type="submit"
                                        class="w-full md:w-auto flex items-center justify-center gap-1.5 bg-green-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-green-700 active:scale-[0.98] transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="hidden md:inline">Setujui</span>
                                </button>
                            </form>

                            {{-- Form Reject --}}
                            <form action="{{ route('admin.tukar-jadwal.reject', $r->id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="catatan_admin"
                                       class="hidden md:block w-full border border-gray-200 rounded-lg px-3 py-1.5 text-xs mb-2 focus:outline-none focus:ring-2 focus:ring-red-300 bg-white"
                                       placeholder="Alasan...">
                                <button type="submit"
                                        class="w-full md:w-auto flex items-center justify-center gap-1.5 bg-white text-red-600 border border-red-200 px-4 py-2 rounded-lg text-xs font-semibold hover:bg-red-50 active:scale-[0.98] transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="hidden md:inline">Tolak</span>
                                </button>
                            </form>
                        @else
                            {{-- Status Read-only untuk yang sudah diproses --}}
                            <span class="text-xs text-gray-400 text-center md:text-right">
                                {{ $r->status === 'disetujui' ? '✅ Telah disetujui' : '❌ Telah ditolak' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($requests->hasPages())
    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
        {{ $requests->links() }}
    </div>
    @endif

    @else
    {{-- Empty State --}}
    <div class="text-center py-16 px-4">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">🎉 Tidak ada request tukar jadwal</p>
        <p class="text-sm text-gray-400 mt-1">Semua jadwal sudah teratur. Pelayan dapat mengajukan request jika perlu.</p>
    </div>
    @endif
</div>

{{-- Custom Styles --}}
@push('styles')
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endpush

@endsection