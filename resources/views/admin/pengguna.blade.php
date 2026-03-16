@extends('layouts.admin')
@section('title', 'Kelola Pengguna')

@section('content')

{{-- Header + Tombol Tambah --}}
<div class="flex items-center justify-between mb-5">
    <p class="text-xs text-gray-400">Total {{ $pengguna->total() }} akun terdaftar</p>
    <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Akun
    </button>
</div>

{{-- Daftar Pengguna --}}
@if($pengguna->count() > 0)

{{-- Desktop: Tabel --}}
<div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider text-left">
                <th class="px-5 py-3">Nama</th>
                <th class="px-5 py-3">Email</th>
                <th class="px-5 py-3">No HP</th>
                <th class="px-5 py-3">Role</th>
                <th class="px-5 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($pengguna as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        @if($p->foto && file_exists(public_path('storage/'.$p->foto)))
                            <img src="{{ asset('storage/'.$p->foto) }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-xs font-bold text-blue-700">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="font-medium text-gray-800">{{ $p->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $p->email }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $p->no_hp ?? '—' }}</td>
                <td class="px-5 py-3">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold
                        {{ $p->role === 'gembala' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($p->role) }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <button type="button"
                                onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->email) }}', '{{ addslashes($p->no_hp ?? '') }}', '{{ $p->role }}')"
                                class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                            Edit
                        </button>
                        <form action="{{ route('admin.pengguna.destroy', $p->id) }}" method="POST"
                              onsubmit="return confirm('Hapus akun {{ addslashes($p->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-50">{{ $pengguna->links() }}</div>
</div>

{{-- Mobile: Card List --}}
<div class="md:hidden space-y-2">
    @foreach($pengguna as $p)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                @if($p->foto && file_exists(public_path('storage/'.$p->foto)))
                    <img src="{{ asset('storage/'.$p->foto) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-sm font-bold text-blue-700">
                        {{ strtoupper(substr($p->name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $p->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $p->email }}</p>
                    @if($p->no_hp)
                    <p class="text-xs text-gray-400">{{ $p->no_hp }}</p>
                    @endif
                </div>
            </div>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0
                {{ $p->role === 'gembala' ? 'bg-indigo-100 text-indigo-700' : 'bg-blue-100 text-blue-700' }}">
                {{ ucfirst($p->role) }}
            </span>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-50 flex gap-2">
            <button type="button"
                    onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->email) }}', '{{ addslashes($p->no_hp ?? '') }}', '{{ $p->role }}')"
                    class="flex-1 py-2 text-xs font-semibold text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                Edit
            </button>
            <form action="{{ route('admin.pengguna.destroy', $p->id) }}" method="POST"
                  onsubmit="return confirm('Hapus akun {{ addslashes($p->name) }}?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach
    <div class="pt-2">{{ $pengguna->links() }}</div>
</div>

@else
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
    </div>
    <p class="text-gray-500 font-medium text-sm">Belum ada pengguna.</p>
    <p class="text-gray-400 text-xs mt-1">Klik tombol Tambah Akun untuk memulai.</p>
</div>
@endif

{{-- ===== MODAL TAMBAH ===== --}}
<div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div>
                <h3 class="font-bold text-gray-900">Tambah Akun Baru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Buat akun untuk pelayan atau gembala</p>
            </div>
            <button onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl leading-none">
                &times;
            </button>
        </div>
        <form action="{{ route('admin.pengguna.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Nama lengkap">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="email@example.com">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="08xxxxxxxxxx">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" required
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="pelayan">Pelayan</option>
                        <option value="gembala">Gembala</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Min. 6 karakter">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-xl hover:bg-blue-800 transition">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT ===== --}}
<div id="modal-edit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div>
                <h3 class="font-bold text-gray-900">Edit Akun</h3>
                <p class="text-xs text-gray-400 mt-0.5" id="edit-email-label">—</p>
            </div>
            <button onclick="document.getElementById('modal-edit').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl leading-none">
                &times;
            </button>
        </div>
        <form id="form-edit" action="" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-name" required
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="edit-email" required
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">No HP</label>
                <input type="text" name="no_hp" id="edit-no-hp"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="08xxxxxxxxxx">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="edit-role"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="pelayan">Pelayan</option>
                        <option value="gembala">Gembala</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="edit-password"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 pr-9 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Kosongkan jika sama">
                        <button type="button" onclick="toggleEditPassword()"
                                class="absolute inset-y-0 right-0 px-2.5 flex items-center text-gray-400 hover:text-gray-600">
                            <svg id="edit-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="edit-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-edit').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-blue-700 rounded-xl hover:bg-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-buka modal tambah jika ada error validasi --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modal-tambah').classList.remove('hidden');
    });
</script>
@endif

@push('scripts')
<script>
function openEditModal(id, name, email, noHp, role) {
    const baseUrl = "{{ url('admin/pengguna') }}";
    document.getElementById('form-edit').action = baseUrl + '/' + id;
    document.getElementById('edit-name').value   = name;
    document.getElementById('edit-email').value  = email;
    document.getElementById('edit-no-hp').value  = noHp;
    document.getElementById('edit-email-label').textContent = email;
    document.getElementById('edit-password').value = '';

    const roleSelect = document.getElementById('edit-role');
    for (let opt of roleSelect.options) {
        opt.selected = opt.value === role;
    }

    document.getElementById('modal-edit').classList.remove('hidden');
}

function toggleEditPassword() {
    const input = document.getElementById('edit-password');
    const show  = document.getElementById('edit-eye-show');
    const hide  = document.getElementById('edit-eye-hide');
    if (input.type === 'password') {
        input.type = 'text';
        show.classList.add('hidden');
        hide.classList.remove('hidden');
    } else {
        input.type = 'password';
        show.classList.remove('hidden');
        hide.classList.add('hidden');
    }
}

// Tutup modal dengan klik backdrop
['modal-tambah', 'modal-edit'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
});
</script>
@endpush

@endsection