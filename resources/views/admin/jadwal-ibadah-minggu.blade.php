@extends('layouts.admin')
@section('title', 'Jadwal Ibadah Minggu')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center justify-between">
    <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-start gap-2">
    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- Header: Pilih Minggu --}}
<div class="bg-white rounded-xl border border-gray-100 p-4 mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Jadwal Pelayan</p>
        <p class="text-base font-bold text-gray-800">{{ $tanggalIbadah->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.jadwal-ibadah-minggu', ['tanggal' => $tanggalIbadah->copy()->subWeek()->format('Y-m-d')]) }}"
           class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <select onchange="window.location.href='{{ route('admin.jadwal-ibadah-minggu') }}?tanggal=' + this.value"
                class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white">
            @foreach($daftarMinggu as $minggu)
            <option value="{{ $minggu->format('Y-m-d') }}" {{ $minggu->isSameDay($tanggalIbadah) ? 'selected' : '' }}>
                {{ $minggu->format('d M Y') }}
            </option>
            @endforeach
        </select>
        <a href="{{ route('admin.jadwal-ibadah-minggu', ['tanggal' => $tanggalIbadah->copy()->addWeek()->format('Y-m-d')]) }}"
           class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

{{-- 
    ========================================
    FORM UTAMA: UPDATE JADWAL
    ========================================
    PENTING: Hanya POST + @csrf, TANPA @method()
    ========================================
--}}
<form action="{{ route('admin.jadwal-ibadah-minggu.update') }}" method="POST" id="form-jadwal">
    @csrf
    <input type="hidden" name="tanggal" value="{{ $tanggalIbadah->format('Y-m-d') }}">

    <div class="bg-white rounded-xl border border-gray-100 mb-5">

        {{-- Table Header (Desktop) --}}
        <div class="hidden sm:grid grid-cols-12 px-4 py-2.5 border-b border-gray-100 bg-gray-50 rounded-t-xl">
            <div class="col-span-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Posisi</div>
            <div class="col-span-4 text-xs font-semibold text-gray-400 uppercase tracking-wide">Pilih dari Akun</div>
            <div class="col-span-4 text-xs font-semibold text-gray-400 uppercase tracking-wide">Nama Pelayan</div>
            <div class="col-span-1 text-xs font-semibold text-gray-400 uppercase tracking-wide text-center">Tampil</div>
        </div>

        @php
        // Index jadwal by ID untuk akses cepat
        $jadwalById = $jadwal->keyBy('id');

        // Bangun peta: posisi_key => grup_nama
        $posisiToGrup = [];
        foreach ($grupPosisi as $grupNama => $keys) {
            foreach ($keys as $k) {
                $posisiToGrup[$k] = $grupNama;
            }
        }

        // Kelompokkan $jadwal ke dalam grup
        $jadwalPerGrup = [];
        $jadwalCustom  = [];
        
        foreach ($jadwal as $j) {
            $grup = null;
            
            // 1. Cek exact match
            if (isset($posisiToGrup[$j->posisi])) {
                $grup = $posisiToGrup[$j->posisi];
            } else {
                // 2. Cek prefix match untuk posisi dinamis (singer_4, penerima_tamu_3, dll)
                foreach ($grupPosisi as $grupNama => $keys) {
                    foreach ($keys as $k) {
                        $prefix = preg_replace('/_\d+$/', '', $k);
                        if (str_starts_with($j->posisi, $prefix . '_') || $j->posisi === $prefix) {
                            $grup = $grupNama;
                            break 2;
                        }
                    }
                }
            }
            
            if ($grup) {
                $jadwalPerGrup[$grup][] = $j;
            } else {
                $jadwalCustom[] = $j;
            }
        }
        @endphp

        {{-- Render per grup --}}
        @foreach ($grupPosisi as $grupNama => $keys)
        @php 
            $rows = $jadwalPerGrup[$grupNama] ?? []; 
            $firstKey = $keys[0] ?? '';
            $prefix = preg_replace('/_\d+$/', '', $firstKey);
        @endphp

        {{-- Grup Header + Tombol Tambah (SELALU MUNCUL) --}}
        <div class="px-4 py-2 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between mt-4 first:mt-0">
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $grupNama }}</span>
            <button type="button"
                    onclick="openTambahModal('{{ $grupNama }}', '{{ $prefix }}')"
                    class="flex items-center gap-1 text-[10px] font-semibold text-blue-600 hover:text-blue-800 px-2 py-1 rounded-lg hover:bg-blue-50 transition">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </button>
        </div>

        {{-- Rows dalam grup --}}
        @if(count($rows) > 0)
            @foreach ($rows as $j)
            @php $isCustom = !isset($posisiList[$j->posisi]); @endphp
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-0 sm:items-center px-4 py-2.5 hover:bg-gray-50/60 transition border-b border-gray-50">

                {{-- Posisi --}}
                <div class="sm:col-span-3 flex items-center gap-2">
                    <div class="w-1.5 h-4 rounded-full {{ $isCustom ? 'bg-purple-400' : 'bg-blue-400' }} flex-shrink-0"></div>
                    <span class="text-sm text-gray-700">
                        {{ $posisiList[$j->posisi] ?? ucwords(str_replace('_', ' ', $j->posisi)) }}
                    </span>
                    @if($isCustom)
                    <span class="text-[9px] bg-purple-50 text-purple-500 px-1.5 py-0.5 rounded-full border border-purple-100">+</span>
                    @endif
                </div>

                {{-- Dropdown Pilih Akun --}}
                <div class="sm:col-span-4 sm:px-2">
                    <select id="select-{{ $j->id }}"
                            onchange="pilihDariDropdown(this, 'input-{{ $j->id }}')"
                            class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white">
                        <option value="">— Pilih pelayan —</option>
                        @foreach($pelayan as $p)
                        <option value="{{ $p->name }}" {{ $j->nama_pelayan === $p->name ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Nama Manual --}}
                <div class="sm:col-span-4 sm:px-2">
                    <input type="text"
                           id="input-{{ $j->id }}"
                           name="jadwal[{{ $j->id }}][nama_pelayan]"
                           value="{{ $j->nama_pelayan }}"
                           class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white"
                           placeholder="Atau ketik nama..."
                           oninput="resetDropdown(this, 'select-{{ $j->id }}')">
                </div>

                {{-- Aksi: Toggle Visible & Hapus --}}
                <div class="sm:col-span-1 flex items-center justify-end sm:justify-center gap-1">
                    
                    {{-- Toggle Visible: Pakai PATCH --}}
                    <form action="{{ route('admin.jadwal-ibadah-minggu.toggle-visible', $j->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" title="{{ $j->is_visible ? 'Sembunyikan' : 'Tampilkan' }}"
                                class="w-7 h-7 flex items-center justify-center rounded-lg transition
                                {{ $j->is_visible ? 'text-green-500 hover:bg-green-50' : 'text-gray-300 hover:bg-gray-50' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($j->is_visible)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                @endif
                            </svg>
                        </button>
                    </form>

                    {{-- Hapus: Hanya untuk posisi custom, pakai DELETE --}}
                    @if($isCustom)
                    <form action="{{ route('admin.jadwal-ibadah-minggu.destroy', $j->id) }}" method="POST"
                          onsubmit="return confirm('Hapus posisi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            {{-- Empty state untuk grup --}}
            <div class="px-4 py-3 text-xs text-gray-400 italic bg-gray-50/50 border-b border-gray-100">
                Belum ada pelayan di grup ini. Klik "Tambah" untuk menambahkan posisi.
            </div>
        @endif

        @endforeach

        {{-- Posisi custom yang tidak masuk grup manapun --}}
        @if(count($jadwalCustom) > 0)
        <div class="px-4 py-2 bg-purple-50/50 border-b border-gray-100 mt-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-purple-400">Posisi Tambahan Lain</span>
        </div>
        @foreach($jadwalCustom as $j)
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-0 sm:items-center px-4 py-2.5 hover:bg-gray-50/60 transition border-b border-gray-50">
            <div class="sm:col-span-3 flex items-center gap-2">
                <div class="w-1.5 h-4 rounded-full bg-purple-400 flex-shrink-0"></div>
                <span class="text-sm text-purple-700">{{ $posisiList[$j->posisi] ?? ucwords(str_replace('_', ' ', $j->posisi)) }}</span>
            </div>
            <div class="sm:col-span-4 sm:px-2">
                <select id="select-{{ $j->id }}" onchange="pilihDariDropdown(this, 'input-{{ $j->id }}')"
                        class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white">
                    <option value="">— Pilih pelayan —</option>
                    @foreach($pelayan as $p)
                    <option value="{{ $p->name }}" {{ $j->nama_pelayan === $p->name ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-4 sm:px-2">
                <input type="text" id="input-{{ $j->id }}" name="jadwal[{{ $j->id }}][nama_pelayan]"
                       value="{{ $j->nama_pelayan }}"
                       class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white"
                       placeholder="Atau ketik nama..."
                       oninput="resetDropdown(this, 'select-{{ $j->id }}')">
            </div>
            <div class="sm:col-span-1 flex items-center justify-end sm:justify-center gap-1">
                <form action="{{ route('admin.jadwal-ibadah-minggu.destroy', $j->id) }}" method="POST"
                      onsubmit="return confirm('Hapus posisi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        @endif

        {{-- Footer Simpan --}}
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50 rounded-b-xl flex items-center justify-between">
            <p class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Satu orang hanya bisa melayani 1 posisi per minggu
            </p>
            <button type="submit"
                    class="flex items-center gap-2 bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Jadwal
            </button>
        </div>
    </div>
</form>

{{-- Modal: Tambah Pelayan dalam Grup --}}
<div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Tambah Pelayan</h3>
                <p id="modal-grup-label" class="text-xs text-gray-400 mt-0.5"></p>
            </div>
            <button onclick="closeTambahModal()" class="text-gray-400 hover:text-gray-600 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="form-tambah-modal" action="{{ route('admin.jadwal-ibadah-minggu.store') }}" method="POST" class="p-5">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggalIbadah->format('Y-m-d') }}">
            <input type="hidden" name="grup" id="modal-grup-key">
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Pelayan</label>
                <input type="text" name="nama_pelayan" id="modal-nama"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Ketik nama..." required>
                <p class="text-xs text-gray-400 mt-1.5">Atau pilih dari akun:</p>
                <select onchange="document.getElementById('modal-nama').value = this.value"
                        class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white">
                    <option value="">— Pilih pelayan —</option>
                    @foreach($pelayan as $p)
                    <option value="{{ $p->name }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeTambahModal()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// ========================================
// FUNGSI DROPDOWN & INPUT
// ========================================
function pilihDariDropdown(select, inputId) {
    const input = document.getElementById(inputId);
    if (input) input.value = select.value;
}

function resetDropdown(input, selectId) {
    const select = document.getElementById(selectId);
    if (!select) return;
    const match = [...select.options].some(opt => opt.value.toLowerCase() === input.value.toLowerCase());
    if (!match) select.value = '';
}

// ========================================
// FUNGSI MODAL TAMBAH
// ========================================
function openTambahModal(grupNama, grupKey) {
    document.getElementById('modal-grup-label').textContent = 'Grup: ' + grupNama;
    document.getElementById('modal-grup-key').value = grupKey;
    document.getElementById('modal-nama').value = '';
    document.getElementById('modal-tambah').classList.remove('hidden');
    document.getElementById('modal-nama').focus();
}

function closeTambahModal() {
    document.getElementById('modal-tambah').classList.add('hidden');
}

// Close modal ketika klik di luar area modal
document.getElementById('modal-tambah')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) closeTambahModal();
});

// Close modal dengan tombol Escape
document.addEventListener('keydown', e => { 
    if (e.key === 'Escape') closeTambahModal(); 
});

// Auto-submit form jika dropdown di modal dipilih
document.querySelector('#modal-tambah select')?.addEventListener('change', function() {
    if (this.value) {
        document.getElementById('form-tambah-modal').submit();
    }
});

// ========================================
// PENTING: PASTIKAN FORM UTAMA TIDAK MENGIRIM _method
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.getElementById('form-jadwal');
    if (mainForm) {
        // Hapus input _method jika ada (dari cache/JS lama)
        const methodInput = mainForm.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
            console.log('✅ _method dihapus dari form utama');
        }
        
        // Intercept submit untuk memastikan tidak ada _method
        mainForm.addEventListener('submit', function(e) {
            const formData = new FormData(this);
            if (formData.has('_method')) {
                formData.delete('_method');
                console.log('✅ _method dihapus saat submit, mengirim POST murni');
            }
        });
    }
});
</script>
@endpush

@endsection