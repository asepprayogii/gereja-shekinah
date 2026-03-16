@extends('layouts.admin')
@section('title', 'Program Gereja')

@section('content')

{{-- Form Tambah Program --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <h3 class="font-bold text-gray-800">Tambah Program Baru</h3>
    </div>
    
    <form action="{{ route('admin.program.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Program *</label>
                <input type="text" name="nama_program" value="{{ old('nama_program') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="TK/PAUD Shekinah...">
                @error('nama_program')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Program</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP (Max 2MB)</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Program</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                          placeholder="Deskripsi lengkap tentang program...">{{ old('deskripsi') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link Informasi</label>
                <input type="url" name="link_info" value="{{ old('link_info') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="https://example.com">
            </div>
            <div class="flex items-center gap-2 mt-5">
                <input type="checkbox" name="is_active" value="1" checked 
                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-300">
                <label class="text-sm text-gray-700">Tampilkan di halaman publik</label>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Program
            </button>
        </div>
    </form>
</div>

{{-- Daftar Program --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
        </div>
        <h3 class="font-bold text-gray-800">Daftar Program Gereja</h3>
    </div>

    @if($program->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($program as $p)
        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition group">
            {{-- Foto Program --}}
            @if($p->foto)
            <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama_program }}" 
                 class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
            @else
            <div class="w-full h-40 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M17 21v-4H7v4M16 3v5h5"/>
                </svg>
            </div>
            @endif

            {{-- Content --}}
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <p class="font-bold text-gray-800">{{ $p->nama_program }}</p>
                    <span class="text-xs px-2 py-1 rounded-full flex items-center gap-1
                        {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="{{ $p->is_active ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"/>
                        </svg>
                        {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                @if($p->deskripsi)
                <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $p->deskripsi }}</p>
                @endif

                @if($p->link_info)
                <a href="{{ $p->link_info }}" target="_blank" 
                   class="text-xs text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-3">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Info
                </a>
                @endif

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <button onclick="openEditModal({{ $p->id }}, {{ json_encode($p) }})"
                            class="text-blue-600 hover:text-blue-800 text-xs font-medium inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                    
                    <form action="{{ route('admin.program.destroy', $p->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-500 hover:text-red-700 text-xs font-medium inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
    <div class="mt-4">
        {{ $program->links() }}
    </div>
    
    @else
    {{-- Empty State --}}
    <div class="text-center py-12">
        <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                      d="M12 8v4l3 3"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Belum ada program gereja.</p>
        <p class="text-gray-300 text-xs mt-1">Mulai dengan menambahkan program baru di atas.</p>
    </div>
    @endif
</div>

{{-- Modal Edit Program --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Edit Program</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbarui informasi program gereja</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            @method('PUT')
            
            <input type="hidden" id="editId" name="id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Program *</label>
                    <input type="text" id="editNama" name="nama_program" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Baru</label>
                    <input type="file" name="foto" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           onchange="previewEditFoto(this)">
                    <div id="currentFotoContainer" class="mt-2 hidden">
                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                        <img id="currentFoto" src="" class="h-16 rounded-lg border border-gray-200">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Program</label>
                    <textarea id="editDeskripsi" name="deskripsi" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Informasi</label>
                    <input type="url" id="editLink" name="link_info"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div class="flex items-center gap-2 mt-5">
                    <input type="checkbox" id="editActive" name="is_active" value="1"
                           class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-300">
                    <label class="text-sm text-gray-700">Tampilkan di halaman publik</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Program
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Open Edit Modal
function openEditModal(id, program) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    form.action = `/admin/program/${id}`;
    document.getElementById('editId').value = program.id;
    document.getElementById('editNama').value = program.nama_program;
    document.getElementById('editDeskripsi').value = program.deskripsi || '';
    document.getElementById('editLink').value = program.link_info || '';
    document.getElementById('editActive').checked = program.is_active == 1;
    
    // Handle current photo
    const fotoContainer = document.getElementById('currentFotoContainer');
    const fotoImg = document.getElementById('currentFoto');
    
    if (program.foto) {
        fotoImg.src = `/storage/${program.foto}`;
        fotoContainer.classList.remove('hidden');
    } else {
        fotoContainer.classList.add('hidden');
    }
    
    modal.classList.remove('hidden');
}

// Close Modal
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editForm').reset();
}

// Preview new photo in edit modal
function previewEditFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const fotoImg = document.getElementById('currentFoto');
            fotoImg.src = e.target.result;
            document.getElementById('currentFotoContainer').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Close modal when clicking outside
document.getElementById('editModal')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) closeEditModal();
});

// Close modal with Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeEditModal();
});
</script>
@endpush

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