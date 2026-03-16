@extends('layouts.pelayan')
@section('title', 'Jadwal Saya')

@section('content')

{{-- Tabs --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 inline-flex mb-6">
    <button onclick="switchTab('minggu')" id="tab-minggu-btn" 
            class="tab-btn active px-4 py-2 text-sm font-medium rounded-lg transition-all bg-blue-600 text-white">
        Ibadah Minggu
    </button>
    <button onclick="switchTab('pelayanan')" id="tab-pelayanan-btn" 
            class="tab-btn px-4 py-2 text-sm font-medium rounded-lg transition-all text-gray-600 hover:bg-gray-50">
        Pelayanan Lain
    </button>
</div>

{{-- Tab: Ibadah Minggu --}}
<div id="tab-minggu" class="tab-content">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-1 h-4 bg-blue-600 rounded-full"></span>
            Ibadah Minggu
        </h3>

        @if($jadwalMinggu->count() > 0)
        <div class="space-y-3">
            @foreach($jadwalMinggu as $j)
            <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 {{ !$j->tanggal->isPast() ? 'border-l-4 border-l-blue-500' : '' }}">
                {{-- Tanggal --}}
                <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center flex-shrink-0 bg-gray-50">
                    <span class="text-sm font-bold text-gray-700">{{ $j->tanggal->format('d') }}</span>
                    <span class="text-[10px] text-gray-500">{{ $j->tanggal->translatedFormat('M') }}</span>
                </div>
                
                {{-- Info --}}
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Ibadah Minggu</p>
                    <p class="text-xs text-gray-500">{{ $j->tanggal->translatedFormat('l, d F Y') }}</p>
                </div>
                
                {{-- Posisi & Status --}}
                <div class="text-right">
                    <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded-full">
                        {{ $posisiList[$j->posisi] ?? $j->posisi }}
                    </span>
                    @if($j->tanggal->isPast())
                    <p class="text-xs text-gray-400 mt-1">Selesai</p>
                    @else
                    <p class="text-xs text-green-600 mt-1">✓ Mendatang</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $jadwalMinggu->links() }}</div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-400 text-sm">Belum ada jadwal ibadah minggu</p>
            <p class="text-gray-300 text-xs mt-1">Pastikan nama Anda sesuai dengan data admin</p>
        </div>
        @endif
    </div>
</div>

{{-- Tab: Pelayanan Lain --}}
<div id="tab-pelayanan" class="tab-content hidden">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-1 h-4 bg-indigo-600 rounded-full"></span>
            Pelayanan Lainnya
        </h3>

        @if($jadwalPelayanan->count() > 0)
        <div class="space-y-3">
            @foreach($jadwalPelayanan as $j)
            <div class="p-3 rounded-lg border border-gray-100 {{ !$j->kegiatan->tanggal->isPast() ? 'border-l-4 border-l-indigo-500' : '' }}">
                <div class="flex items-center gap-3">
                    {{-- Tanggal --}}
                    <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center flex-shrink-0 bg-gray-50">
                        <span class="text-sm font-bold text-gray-700">{{ $j->kegiatan->tanggal->format('d') }}</span>
                        <span class="text-[10px] text-gray-500">{{ $j->kegiatan->tanggal->translatedFormat('M') }}</span>
                    </div>
                    
                    {{-- Info --}}
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $j->kegiatan->nama_kegiatan }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $j->kegiatan->tanggal->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ substr($j->kegiatan->jam_mulai, 0, 5) }} WIB
                        </p>
                    </div>
                    
                    {{-- Posisi & Status --}}
                    <div class="text-right">
                        <span class="text-xs px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full">
                            {{ $j->posisi }}
                        </span>
                        @if($j->kegiatan->tanggal->isPast())
                        <p class="text-xs text-gray-400 mt-1">Selesai</p>
                        @else
                        <p class="text-xs text-green-600 mt-1">✓ Mendatang</p>
                        @endif
                    </div>
                </div>
                
                {{-- Catatan jika ada --}}
                @if($j->catatan)
                <div class="mt-2 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                    📝 {{ $j->catatan }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $jadwalPelayanan->links() }}</div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-400 text-sm">Belum ada jadwal pelayanan lainnya</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Show selected tab
    document.getElementById(`tab-${tabName}`).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('text-gray-600', 'hover:bg-gray-50');
    });
    
    // Active button
    document.getElementById(`tab-${tabName}-btn`).classList.add('bg-blue-600', 'text-white');
    document.getElementById(`tab-${tabName}-btn`).classList.remove('text-gray-600', 'hover:bg-gray-50');
}

// Initialize first tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('minggu');
});
</script>
@endpush

@endsection