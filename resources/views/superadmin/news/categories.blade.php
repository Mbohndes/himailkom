@extends('layouts.superadmin')
@section('title', 'Kategori Berita')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10" x-data="{ editMode: false, editId: null, editName: '', editDesc: '', editUrl: '' }">
    
    <!-- Header -->
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('superadmin.news.dashboard') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
</a>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Kategori Berita</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelompokkan berita berdasarkan topik utamanya.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">Data gagal disimpan, nama kategori mungkin sudah ada.</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- KOLOM KIRI: Form Tambah / Edit -->
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 lg:sticky lg:top-6">
            <h3 class="font-bold text-slate-800 text-base mb-4" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h3>
            
            <form :action="editMode ? editUrl : '{{ route('superadmin.news.categories.store') }}'" method="POST" class="space-y-4">
                @csrf
                <!-- Method PUT jika mode edit -->
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kategori</label>
                    <input type="text" name="name" x-model="editName" required placeholder="Contoh: Kegiatan HIMA" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" x-model="editDesc" rows="3" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"></textarea>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <template x-if="editMode">
                        <button type="button" @click="editMode = false; editName = ''; editDesc = '';" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold rounded-xl transition-colors">Batal</button>
                    </template>
                    <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-xl shadow-md transition-colors" x-text="editMode ? 'Simpan Perubahan' : 'Tambah Kategori'"></button>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: Tabel Data -->
        <div class="lg:col-span-2 bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE] text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Nama & Slug</th>
                        <th class="px-6 py-4">Total Berita</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse ($categories as $cat)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $cat->name }}</div>
                            <div class="text-xs text-slate-400 mt-1 font-medium">/{{ $cat->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-indigo-50 text-[#5442F5] font-bold px-3 py-1 rounded-full text-xs">{{ $cat->news_count }} Artikel</span>
                        </td>
                        <td class="px-6 py-4 flex items-center justify-end gap-2">
                            <!-- Tombol Trigger AlpineJS untuk Edit (Ubah menjadi superadmin.news.categories.update) -->
                            <button type="button" @click="editMode = true; editId = {{ $cat->id }}; editName = '{{ addslashes($cat->name) }}'; editDesc = '{{ addslashes($cat->description ?? '') }}'; editUrl = '{{ route('superadmin.news.categories.update', $cat->id) }}'" class="p-2 text-[#5442F5] hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            
                            <!-- Tombol Hapus (Ubah menjadi superadmin.news.categories.destroy) -->
                            <form action="{{ route('superadmin.news.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada kategori yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100">{{ $categories->links() }}</div>
        </div>
    </div>
</div>
@endsection