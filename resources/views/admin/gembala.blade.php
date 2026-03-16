@extends('layouts.admin')
@section('title', 'Keluarga Gembala')

@section('content')

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

<div class="mb-4">
    <p class="text-xs text-gray-400">Klik kartu untuk mengedit data anggota keluarga gembala.</p>
</div>

{{-- Grid kartu --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @php
        // Kelompokkan data berdasarkan peran
        $gembala = $keluarga->firstWhere('peran', 'Gembala');
        $ibuGembala = $keluarga->firstWhere('peran', 'Ibu Gembala');
        $anakAnak = $keluarga->filter(fn($k) => str_contains($k->peran, 'Anak'))->values();
    @endphp

    {{-- KARTU GEMBALA --}}
    <div onclick="openModal({{ $gembala?->id ?? 'null' }}, 'Gembala', {{ json_encode($gembala?->nama) }}, {{ json_encode($gembala?->bio) }}, {{ $gembala?->foto ? json_encode(asset('storage/'.$gembala->foto)) : 'null' }})"
         class="bg-white border border-gray-100 rounded-2xl p-5 text-center cursor-pointer hover:shadow-md hover:border-blue-100 transition group">
        <div class="relative w-24 h-24 mx-auto mb-4">
            @if($gembala?->foto)
            <img src="{{ asset('storage/' . $gembala->foto) }}" alt="{{ $gembala->nama }}"
                 class="w-24 h-24 rounded-full object-cover ring-2 ring-white shadow-md">
            @else
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center ring-2 ring-white shadow-md">
                <svg class="w-10 h-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            @endif
            <div class="absolute bottom-0 right-0 w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center shadow opacity-0 group-hover:opacity-100 transition">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-widest text-blue-500 mb-1">GEMBALA</p>
        @if($gembala?->nama)
        <p class="font-bold text-gray-800 text-sm">{{ $gembala->nama }}</p>
        @else
        <p class="text-gray-300 text-sm italic">-</p>
        @endif
        @if($gembala?->bio)
        <p class="text-xs text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $gembala->bio }}</p>
        @endif
    </div>

    {{-- KARTU IBU GEMBALA --}}
    <div onclick="openModal({{ $ibuGembala?->id ?? 'null' }}, 'Ibu Gembala', {{ json_encode($ibuGembala?->nama) }}, {{ json_encode($ibuGembala?->bio) }}, {{ $ibuGembala?->foto ? json_encode(asset('storage/'.$ibuGembala->foto)) : 'null' }})"
         class="bg-white border border-gray-100 rounded-2xl p-5 text-center cursor-pointer hover:shadow-md hover:border-pink-100 transition group">
        <div class="relative w-24 h-24 mx-auto mb-4">
            @if($ibuGembala?->foto)
            <img src="{{ asset('storage/' . $ibuGembala->foto) }}" alt="{{ $ibuGembala->nama }}"
                 class="w-24 h-24 rounded-full object-cover ring-2 ring-white shadow-md">
            @else
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-50 to-pink-100 flex items-center justify-center ring-2 ring-white shadow-md">
                <svg class="w-10 h-10 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            @endif
            <div class="absolute bottom-0 right-0 w-7 h-7 bg-pink-500 rounded-full flex items-center justify-center shadow opacity-0 group-hover:opacity-100 transition">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-widest text-pink-500 mb-1">IBU GEMBALA</p>
        @if($ibuGembala?->nama)
        <p class="font-bold text-gray-800 text-sm">{{ $ibuGembala->nama }}</p>
        @else
        <p class="text-gray-300 text-sm italic">-</p>
        @endif
        @if($ibuGembala?->bio)
        <p class="text-xs text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $ibuGembala->bio }}</p>
        @endif
    </div>

    {{-- KARTU ANAK-ANAK (3 SLOT) --}}
    @for($i = 0; $i < 3; $i++)
        @php
            $anak = $anakAnak[$i] ?? null;
            $nomor = $i + 1;
            $peran = 'Anak ' . $nomor;
        @endphp
        <div onclick="openModal({{ $anak?->id ?? 'null' }}, '{{ $peran }}', {{ json_encode($anak?->nama) }}, {{ json_encode($anak?->bio) }}, {{ $anak?->foto ? json_encode(asset('storage/'.$anak->foto)) : 'null' }})"
             class="bg-white border border-gray-100 rounded-2xl p-5 text-center cursor-pointer hover:shadow-md hover:border-purple-100 transition group">
            <div class="relative w-24 h-24 mx-auto mb-4">
                @if($anak?->foto)
                <img src="{{ asset('storage/' . $anak->foto) }}" alt="{{ $anak->nama }}"
                     class="w-24 h-24 rounded-full object-cover ring-2 ring-white shadow-md">
                @else
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center ring-2 ring-white shadow-md">
                    <svg class="w-10 h-10 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
                <div class="absolute bottom-0 right-0 w-7 h-7 bg-purple-600 rounded-full flex items-center justify-center shadow opacity-0 group-hover:opacity-100 transition">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-purple-500 mb-1">ANAK {{ $nomor }}</p>
            @if($anak?->nama)
            <p class="font-bold text-gray-800 text-sm">{{ $anak->nama }}</p>
            @else
            <p class="text-gray-300 text-sm italic">-</p>
            @endif
            @if($anak?->bio)
            <p class="text-xs text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $anak->bio }}</p>
            @endif
        </div>
    @endfor
</div>

{{-- Modal Edit --}}
<div id="modal-edit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Edit Anggota</h3>
                <p id="modal-peran-label" class="text-xs text-blue-600 mt-0.5 font-medium"></p>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="form-edit" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf @method('PUT')

            {{-- Preview foto --}}
            <div class="flex flex-col items-center mb-5">
                <div class="relative">
                    <div id="foto-preview-wrap" class="w-24 h-24 rounded-full overflow-hidden ring-2 ring-gray-100 shadow-sm bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                        <img id="foto-preview-img" src="" alt="" class="w-full h-full object-cover hidden">
                        <svg id="foto-preview-icon" class="w-10 h-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <label class="mt-3 cursor-pointer text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                    Ganti Foto
                    <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                </label>
                <label id="hapus-foto-wrap" class="hidden mt-1 flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="hapus_foto" value="1" class="w-3.5 h-3.5 text-red-500 rounded border-gray-300">
                    <span class="text-xs text-red-400">Hapus foto</span>
                </label>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama</label>
                    <input type="text" name="nama" id="modal-nama"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Nama lengkap...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Bio / Profil Singkat</label>
                    <textarea name="bio" id="modal-bio" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                              placeholder="Profil singkat..."></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-5 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const baseUrl = "{{ url('admin/gembala') }}";

function openModal(id, peran, nama, bio, fotoUrl) {
    const modal = document.getElementById('modal-edit');
    const form = document.getElementById('form-edit');
    const peranLabel = document.getElementById('modal-peran-label');
    
    // Set peran label
    peranLabel.textContent = peran;
    
    // Set form action
    if (id && id !== 'null') {
        // Mode UPDATE: data sudah ada
        form.action = baseUrl + '/' + id;
        form.querySelector('input[name="_method"]').value = 'PUT';
    } else {
        // Mode CREATE: data baru untuk slot kosong
        form.action = baseUrl;
        form.querySelector('input[name="_method"]').value = 'POST';
    }
    
    // Isi form dengan data yang ada (jika ada)
    document.getElementById('modal-nama').value = nama ?? '';
    document.getElementById('modal-bio').value = bio ?? '';

    // Handle foto preview
    const img = document.getElementById('foto-preview-img');
    const icon = document.getElementById('foto-preview-icon');
    const hapusWrap = document.getElementById('hapus-foto-wrap');

    if (fotoUrl && fotoUrl !== 'null') {
        img.src = fotoUrl;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
        hapusWrap.classList.remove('hidden');
    } else {
        img.src = '';
        img.classList.add('hidden');
        icon.classList.remove('hidden');
        hapusWrap.classList.add('hidden');
    }

    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal-edit').classList.add('hidden');
    document.getElementById('form-edit').reset();
}

function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('foto-preview-img');
            const icon = document.getElementById('foto-preview-icon');
            img.src = e.target.result;
            img.classList.remove('hidden');
            icon.classList.add('hidden');
            document.getElementById('hapus-foto-wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Close modal when clicking outside
document.getElementById('modal-edit')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) closeModal();
});

// Close modal with Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>
@endpush

@endsection