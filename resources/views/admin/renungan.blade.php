@extends('layouts.admin')
@section('title', 'Kelola Renungan')

@section('content')

{{-- Form Tambah --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-5">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <h3 class="font-bold text-gray-800 text-sm">Tulis Renungan Baru</h3>
    </div>

    <form action="{{ route('admin.renungan.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Contoh: Iman yang Teguh">
                @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Ayat Alkitab</label>
                <input type="text" name="ayat" value="{{ old('ayat') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Contoh: Yohanes 3:16">
            </div>
        </div>

        <div class="mb-3">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Isi Renungan <span class="text-red-500">*</span></label>
            <textarea name="isi" rows="5" required
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                      placeholder="Tulis isi renungan di sini...">{{ old('isi') }}</textarea>
            @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Publish <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_publish" value="{{ old('tanggal_publish', date('Y-m-d')) }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <label class="flex items-center gap-2 cursor-pointer mt-5">
                <input type="checkbox" name="is_published" value="1"
                       {{ old('is_published') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 rounded border-gray-300">
                <span class="text-sm text-gray-700">Langsung publish</span>
            </label>
            <button type="submit"
                    class="mt-5 flex items-center gap-2 bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- Daftar Renungan --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        <h3 class="font-bold text-gray-800 text-sm">Daftar Renungan</h3>
    </div>

    @if($renungan->count() > 0)

    {{-- Desktop --}}
    <div class="hidden md:block">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider text-left">
                    <th class="px-4 py-3 rounded-l-lg">Judul</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 rounded-r-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($renungan as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800 text-sm">{{ $r->judul }}</p>
                        @if($r->ayat)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $r->ayat }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->penulis->name }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->tanggal_publish->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                            {{ $r->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $r->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <button type="button"
                                    onclick="openEditRenungan({{ $r->id }}, {{ json_encode($r->judul) }}, {{ json_encode($r->ayat ?? '') }}, {{ json_encode($r->isi) }}, '{{ $r->tanggal_publish->format('Y-m-d') }}', {{ $r->is_published ? 'true' : 'false' }})"
                                    class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                                Edit
                            </button>
                            <form action="{{ route('admin.renungan.destroy', $r->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus renungan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile: Card --}}
    <div class="md:hidden space-y-2">
        @foreach($renungan as $r)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $r->judul }}</p>
                    @if($r->ayat)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $r->ayat }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-1">{{ $r->penulis->name }} · {{ $r->tanggal_publish->format('d M Y') }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0
                    {{ $r->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $r->is_published ? 'Published' : 'Draft' }}
                </span>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 flex gap-2">
                <button type="button"
                        onclick="openEditRenungan({{ $r->id }}, {{ json_encode($r->judul) }}, {{ json_encode($r->ayat ?? '') }}, {{ json_encode($r->isi) }}, '{{ $r->tanggal_publish->format('Y-m-d') }}', {{ $r->is_published ? 'true' : 'false' }})"
                        class="flex-1 py-2 text-xs font-semibold text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    Edit
                </button>
                <form action="{{ route('admin.renungan.destroy', $r->id) }}" method="POST"
                      onsubmit="return confirm('Hapus renungan ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $renungan->links() }}</div>

    @else
    <div class="text-center py-10">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Belum ada renungan.</p>
    </div>
    @endif
</div>

{{-- ===== MODAL EDIT RENUNGAN ===== --}}
<div id="modal-edit-renungan" class="hidden fixed inset-0 bg-black/50 z-50 flex items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl my-6">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl z-10">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900">Edit Renungan</h3>
            </div>
            <button onclick="document.getElementById('modal-edit-renungan').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl leading-none">
                &times;
            </button>
        </div>

        <form id="form-edit-renungan" action="" method="POST" class="p-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="edit-r-judul" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Ayat Alkitab</label>
                    <input type="text" name="ayat" id="edit-r-ayat"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Yohanes 3:16">
                </div>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Isi Renungan <span class="text-red-500">*</span></label>
                <textarea name="isi" id="edit-r-isi" rows="7" required
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"></textarea>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Publish <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_publish" id="edit-r-tanggal"
                           class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <label class="flex items-center gap-2 cursor-pointer mt-5">
                    <input type="checkbox" name="is_published" id="edit-r-published" value="1"
                           class="w-4 h-4 text-blue-600 rounded border-gray-300">
                    <span class="text-sm text-gray-700">Publish</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 mt-5 pt-4 border-t border-gray-100">
                <button type="button"
                        onclick="document.getElementById('modal-edit-renungan').classList.add('hidden')"
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
function openEditRenungan(id, judul, ayat, isi, tanggal, isPublished) {
    const baseUrl = "{{ url('admin/renungan') }}";
    document.getElementById('form-edit-renungan').action = baseUrl + '/' + id;
    document.getElementById('edit-r-judul').value     = judul;
    document.getElementById('edit-r-ayat').value      = ayat;
    document.getElementById('edit-r-isi').value       = isi;
    document.getElementById('edit-r-tanggal').value   = tanggal;
    document.getElementById('edit-r-published').checked = isPublished;
    document.getElementById('modal-edit-renungan').classList.remove('hidden');
}

document.getElementById('modal-edit-renungan').addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});
</script>
@endpush

@endsection