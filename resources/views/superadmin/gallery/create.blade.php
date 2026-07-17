@extends('layouts.superadmin')
@section('title', 'Tambah Album HIMA')

@section('content')
<div class="max-w-[1000px] mx-auto w-full flex flex-col gap-6 pb-10">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('superadmin.gallery.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Tambah Album Baru</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Buat katalog visual untuk dokumentasi acara organisasi.</p>
        </div>
    </div>

    <form action="{{ route('superadmin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[30px] p-8 shadow-sm border border-slate-100 space-y-6">
        @csrf
        
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kegiatan / Judul Album <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="Contoh: Makrab Mahasiswa 2026" class="w-full bg-[#F4F7FE] border-none text-lg font-bold text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Link Folder Google Drive (Wajib) <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </div>
                <input type="url" name="drive_link" required placeholder="https://drive.google.com/drive/folders/..." class="w-full bg-blue-50 border-none text-sm font-medium text-blue-700 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>
            <p class="text-xs text-slate-400 mt-2">Pastikan pengaturan privasi folder Google Drive diset ke "Siapa saja yang memiliki link" (Anyone with the link).</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Pelaksanaan</label>
                <input type="date" name="activity_date" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Divisi Pelaksana</label>
                <select name="division" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                    <option value="">Umum / Lintas Divisi</option>
                    <option value="Humas">Humas</option>
                    <option value="Kaderisasi">Kaderisasi</option>
                    <option value="Minat Bakat">Minat Bakat</option>
                    <option value="Keilmuan">Keilmuan</option>
                </select>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Foto Sampul (Thumbnail) - Opsional</label>
            <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-[#5442F5] hover:file:bg-indigo-100 bg-[#F4F7FE] rounded-xl p-1 cursor-pointer">
            <p class="text-[11px] text-slate-400 mt-2">Jika dikosongkan, sistem akan membuatkan gambar pola (placeholder) secara otomatis.</p>
        </div>

        <button type="submit" class="w-full py-3.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-extrabold rounded-xl shadow-lg transition-colors mt-4">
            Simpan Album
        </button>
    </form>
</div>
@endsection