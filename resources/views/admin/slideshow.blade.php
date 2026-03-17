@extends('layouts.admin')
@section('title', 'Hero Slideshow')

@section('content')

{{-- Toolbar --}}
<div class="flex items-center justify-between mb-5">
    <p class="text-xs text-gray-400">{{ $slideshow->count() }} foto terdaftar</p>
    <button onclick="toggleForm()"
            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
        <svg id="btn-icon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="hidden sm:inline">Upload Foto</span>
    </button>
</div>

{{-- Form Upload (toggle) --}}
<div id="form-tambah" class="hidden mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4 sm:p-5">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Upload Foto Slideshow</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    Gunakan foto <strong>landscape</strong> — minimal <strong>1280×480px</strong>, ideal <strong>1920×600px</strong>.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.slideshow.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Pilih Foto <span class="text-red-500">*</span>
                    </label>
                    <div id="preview-box" class="hidden w-full h-40 rounded-xl overflow-hidden border border-gray-200 mb-2 bg-gray-100">
                        <img id="preview-img" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <input type="file" name="foto" accept="image/*" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"
                           onchange="previewFoto(this)">
                    @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Fokus Tampilan
                        <span class="text-gray-400 font-normal">— bagian foto yang jadi pusat perhatian</span>
                    </label>
                    <div class="grid grid-cols-3 gap-1.5">
                        @php
                        $positions = [
                            ['value'=>'top left',     'label'=>'↖'],
                            ['value'=>'top center',   'label'=>'↑'],
                            ['value'=>'top right',    'label'=>'↗'],
                            ['value'=>'center left',  'label'=>'←'],
                            ['value'=>'center',       'label'=>'●'],
                            ['value'=>'center right', 'label'=>'→'],
                            ['value'=>'bottom left',  'label'=>'↙'],
                            ['value'=>'bottom center','label'=>'↓'],
                            ['value'=>'bottom right', 'label'=>'↘'],
                        ];
                        @endphp
                        @foreach($positions as $pos)
                        <label class="cursor-pointer">
                            <input type="radio" name="object_position" value="{{ $pos['value'] }}"
                                   {{ $pos['value'] === 'center' ? 'checked' : '' }}
                                   class="sr-only peer"
                                   onchange="updatePreviewPosition('{{ $pos['value'] }}')">
                            <div class="peer-checked:bg-blue-700 peer-checked:text-white peer-checked:border-blue-700
                                        border border-gray-200 rounded-lg py-2 text-center text-sm font-bold
                                        text-gray-500 hover:border-blue-300 hover:bg-blue-50 transition select-none">
                                {{ $pos['label'] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col justify-between gap-3">
                    <label class="flex items-center gap-2 cursor-pointer mt-1">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="w-4 h-4 text-blue-600 rounded border-gray-300">
                        <span class="text-sm text-gray-700">Langsung aktifkan</span>
                    </label>
                    <p class="text-[10px] text-gray-400 leading-relaxed">
                        Urutan akan otomatis ditambahkan di akhir. Atur ulang urutan dengan drag & drop setelah upload.
                    </p>
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

{{-- Daftar Slideshow --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800 text-sm">Daftar Foto Slideshow</h3>
        @if($slideshow->count() > 1)
        <div class="flex items-center gap-2">
            <span id="sort-hint" class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
                Geser untuk atur urutan
            </span>
            <span id="sort-saving" class="hidden text-xs text-blue-600 font-medium">Menyimpan...</span>
            <span id="sort-saved" class="hidden text-xs text-green-600 font-medium">✓ Tersimpan</span>
        </div>
        @endif
    </div>

    @if($slideshow->count() > 0)
    <div id="sortable-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($slideshow as $slide)
        <div class="slide-card border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition cursor-grab active:cursor-grabbing select-none"
             data-id="{{ $slide->id }}">

            {{-- Foto --}}
            <div class="relative h-36 bg-gray-100">
                <img src="{{ $slide->foto }}"
                     alt="Slide {{ $loop->iteration }}"
                     class="w-full h-full object-cover pointer-events-none"
                     style="object-position: {{ $slide->object_position ?? 'center' }}">

                {{-- Drag handle indicator --}}
                <div class="absolute top-2 left-2 w-6 h-6 rounded-md bg-black/40 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 6a2 2 0 100-4 2 2 0 000 4zm0 8a2 2 0 100-4 2 2 0 000 4zm0 8a2 2 0 100-4 2 2 0 000 4zm8-16a2 2 0 100-4 2 2 0 000 4zm0 8a2 2 0 100-4 2 2 0 000 4zm0 8a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                </div>

                {{-- Badge urutan --}}
                <div class="absolute top-2 right-2">
                    <span class="urutan-badge w-6 h-6 rounded-full bg-black/50 text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $loop->iteration }}
                    </span>
                </div>

                {{-- Badge status --}}
                <div class="absolute bottom-2 left-2">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                        {{ $slide->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                        {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                {{-- Posisi --}}
                @if($slide->object_position && $slide->object_position !== 'center')
                <div class="absolute bottom-2 right-2">
                    <span class="px-1.5 py-0.5 rounded bg-black/40 text-white text-[9px] backdrop-blur-sm">
                        {{ $slide->object_position }}
                    </span>
                </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="p-3 flex items-center justify-between gap-2">
                <form action="{{ route('admin.slideshow.toggle', $slide->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg transition
                            {{ $slide->is_active
                                ? 'text-orange-600 bg-orange-50 hover:bg-orange-100'
                                : 'text-green-600 bg-green-50 hover:bg-green-100' }}">
                        {{ $slide->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>

                <form action="{{ route('admin.slideshow.destroy', $slide->id) }}" method="POST"
                      onsubmit="return confirm('Hapus foto slideshow ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="text-center py-12">
        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Belum ada foto slideshow.</p>
        <p class="text-gray-400 text-xs mt-1">Klik Upload Foto untuk menambahkan.</p>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
// ── Toggle Form ──────────────────────────────────────────
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

// ── Preview foto ─────────────────────────────────────────
function previewFoto(input) {
    const box = document.getElementById('preview-box');
    const img = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            box.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updatePreviewPosition(pos) {
    const img = document.getElementById('preview-img');
    if (img) img.style.objectPosition = pos;
}

// ── Drag & Drop Sortable ─────────────────────────────────
const grid = document.getElementById('sortable-grid');
if (grid) {
    Sortable.create(grid, {
        animation: 200,
        ghostClass: 'opacity-30',
        dragClass: 'shadow-2xl',
        onEnd: function () {
            // Kumpulkan ID sesuai urutan baru
            const order = [...grid.querySelectorAll('.slide-card')]
                .map(el => el.dataset.id);

            // Update badge urutan di UI
            grid.querySelectorAll('.urutan-badge').forEach((badge, i) => {
                badge.textContent = i + 1;
            });

            // Tampilkan status
            const hint   = document.getElementById('sort-hint');
            const saving = document.getElementById('sort-saving');
            const saved  = document.getElementById('sort-saved');
            if (hint) hint.classList.add('hidden');
            if (saving) saving.classList.remove('hidden');
            if (saved) saved.classList.add('hidden');

            // Kirim ke server
            fetch("{{ route('admin.slideshow.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ order }),
            })
            .then(res => res.json())
            .then(() => {
                if (saving) saving.classList.add('hidden');
                if (saved)  saved.classList.remove('hidden');
                setTimeout(() => {
                    if (saved) saved.classList.add('hidden');
                    if (hint)  hint.classList.remove('hidden');
                }, 2000);
            })
            .catch(() => {
                if (saving) saving.classList.add('hidden');
                if (hint)   hint.classList.remove('hidden');
            });
        }
    });
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', () => toggleForm());
@endif
</script>
@endpush

@endsection