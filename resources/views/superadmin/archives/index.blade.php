@extends('layouts.superadmin')
@section('title', 'Arsip Digital HIMA')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center gap-4 mb-2">
        <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center text-[#5442F5] shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
        </div>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Pusat Arsip Digital</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Simpan rujukan dokumen resmi organisasi via Google Drive atau Server Lokal.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
            {{ $errors->first() ?? 'Gagal mengarsipkan data. Pastikan format input benar.' }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 lg:sticky lg:top-6">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">Arsipkan Dokumen</h3>
            
            <form action="{{ route('superadmin.archives.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Dokumen</label>
                    <input type="text" name="title" required placeholder="Contoh: Proposal Makrab 2026" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori</label>
                    <select name="category" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">URL / Link Google Drive</label>
                    <input type="url" name="drive_link" placeholder="https://drive.google.com/..." class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Atau Upload File Fisik (Opsional)</label>
                    <input type="file" name="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-[#5442F5] hover:file:bg-indigo-100 bg-[#F4F7FE] rounded-xl p-1">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="2" placeholder="Keterangan tambahan..." class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"></textarea>
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Simpan ke Arsip
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-4">
            
            <form action="{{ route('superadmin.archives.index') }}" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama dokumen..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                <select name="category" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm">Cari</button>
                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('superadmin.archives.index') }}" class="px-4 py-2.5 bg-red-50 text-red-600 rounded-xl text-sm font-bold flex items-center justify-center">X</a>
                @endif
            </form>

            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F4F7FE]/50 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                                <th class="px-6 py-4">Nama Dokumen</th>
                                <th class="px-6 py-4">Metode Simpan</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                            @forelse ($archives as $arsip)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 mb-1">{{ $arsip->title }}</div>
                                    @if($arsip->description)
                                        <div class="text-[11px] text-slate-400 truncate w-48">{{ $arsip->description }}</div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 font-semibold text-xs">
                                    @if($arsip->drive_link)
                                        <span class="text-blue-600 flex items-center gap-1">🌐 Google Drive</span>
                                    @endif
                                    @if($arsip->file_path)
                                        <span class="text-emerald-600 flex items-center gap-1 mt-0.5">💾 File Lokal</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="bg-indigo-50 text-[#5442F5] text-xs font-extrabold px-2.5 py-1 rounded-md">{{ $arsip->category }}</span>
                                end</td>
                                
                                <td class="px-6 py-4 flex justify-end gap-2">
                                    @if($arsip->drive_link)
                                        <a href="{{ $arsip->drive_link }}" target="_blank" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Buka Google Drive">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @endif
                                    @if($arsip->file_path)
                                        <a href="{{ asset('storage/' . $arsip->file_path) }}" target="_blank" download class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors" title="Unduh File Lokal">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('superadmin.archives.destroy', $arsip->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini dari rekam arsip?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-400 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada rekam arsip dokumen.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/30">{{ $archives->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection