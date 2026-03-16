@extends('layouts.pelayan')
@section('title', 'Tukar Jadwal')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-center gap-2">
    <span>✓</span>
    <span>{{ session('success') }}</span>
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-center gap-2">
    <span>✗</span>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- Header --}}
<div class="mb-6">
    <p class="text-sm text-gray-500 mt-1">Ajukan pertukaran jadwal dengan pelayan lain</p>
</div>

{{-- Form Request Tukar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <span class="w-1 h-4 bg-blue-600 rounded-full"></span>
        Request Tukar Jadwal
    </h3>

    @if($myJadwalPelayanan->count() > 0 || $myJadwalMinggu->count() > 0)
    <form action="{{ route('pelayan.tukar-jadwal.store') }}" method="POST" id="form-tukar">
        @csrf

        {{-- Pilih Tipe --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Jadwal</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="tipe" value="minggu"
                           onchange="toggleTipe(this.value)"
                           {{ $myJadwalMinggu->count() > 0 ? 'checked' : '' }}
                           class="text-blue-600">
                    <span class="text-sm text-gray-700">Ibadah Minggu</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="tipe" value="pelayanan"
                           onchange="toggleTipe(this.value)"
                           {{ $myJadwalMinggu->count() === 0 ? 'checked' : '' }}
                           class="text-blue-600">
                    <span class="text-sm text-gray-700">Pelayanan Lain</span>
                </label>
            </div>
        </div>

        {{-- Pilih Jadwal --}}
        <div class="mb-4">
            {{-- Dropdown Ibadah Minggu --}}
            <div id="select-minggu" class="{{ $myJadwalMinggu->count() === 0 ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jadwal Minggu</label>
                <select name="jadwal_minggu_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($myJadwalMinggu as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->tanggal->format('d M Y') }} — {{ $posisiList[$j->posisi] ?? $j->posisi }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown Pelayanan --}}
            <div id="select-pelayanan" class="{{ $myJadwalMinggu->count() > 0 ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jadwal Pelayanan</label>
                <select name="jadwal_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($myJadwalPelayanan as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->kegiatan->nama_kegiatan }} - {{ $j->kegiatan->tanggal->format('d M Y') }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Pengganti --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pengganti <span class="text-gray-400 font-normal">(opsional)</span></label>
            <select name="pengganti_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">-- Belum ada pengganti --</option>
                @foreach($pelayan as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Alasan --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <textarea name="alasan" rows="3" required
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                      placeholder="Tulis alasan Anda..."></textarea>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Kirim Request
        </button>
    </form>

    @else
    <div class="text-center py-6">
        <p class="text-gray-400 text-sm">Tidak ada jadwal mendatang yang bisa ditukar</p>
    </div>
    @endif
</div>

{{-- Riwayat Request --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <span class="w-1 h-4 bg-gray-600 rounded-full"></span>
        Riwayat Request
    </h3>

    @if($requests->count() > 0)
    <div class="space-y-3">
        @foreach($requests as $r)
        <div class="p-3 rounded-lg border border-gray-100">
            <div class="flex items-start justify-between gap-2">
                {{-- Info Jadwal --}}
                <div class="flex-1">
                    {{-- Status Badge --}}
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $r->status === 'disetujui' ? 'bg-green-100 text-green-700' :
                               ($r->status === 'ditolak' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $r->status }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $r->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Detail Jadwal --}}
                    @if($r->tipe === 'minggu' && $r->jadwalMinggu)
                    <p class="text-sm font-medium text-gray-800">
                        Ibadah Minggu - {{ $r->jadwalMinggu->tanggal->format('d M Y') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Posisi: {{ $posisiList[$r->jadwalMinggu->posisi] ?? $r->jadwalMinggu->posisi }}
                    </p>
                    @elseif($r->tipe === 'pelayanan' && $r->jadwal)
                    <p class="text-sm font-medium text-gray-800">
                        {{ $r->jadwal->kegiatan->nama_kegiatan }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $r->jadwal->kegiatan->tanggal->format('d M Y') }} • {{ $r->jadwal->posisi }}
                    </p>
                    @endif

                    {{-- Alasan --}}
                    <p class="text-xs text-gray-500 mt-1">Alasan: {{ $r->alasan }}</p>
                    
                    {{-- Pengganti --}}
                    @if($r->pengganti)
                    <p class="text-xs text-gray-500">Pengganti: {{ $r->pengganti->name }}</p>
                    @endif

                    {{-- Catatan Admin --}}
                    @if($r->catatan_admin)
                    <p class="text-xs text-gray-400 mt-1 pt-1 border-t border-gray-50">
                        Admin: {{ $r->catatan_admin }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-6">
        <p class="text-gray-400 text-sm">Belum ada request tukar jadwal</p>
    </div>
    @endif
</div>

<script>
function toggleTipe(tipe) {
    const selectMinggu = document.getElementById('select-minggu');
    const selectPelayanan = document.getElementById('select-pelayanan');

    if (tipe === 'minggu') {
        selectMinggu.classList.remove('hidden');
        selectPelayanan.classList.add('hidden');
    } else {
        selectMinggu.classList.add('hidden');
        selectPelayanan.classList.remove('hidden');
    }
}
</script>

@endsection