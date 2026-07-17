@extends('layouts.superadmin')
@section('title', 'Galeri HIMA')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Galeri Dokumentasi</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kumpulan dokumentasi foto dan video organisasi.</p>
        </div>
        
        @unlessrole('Anggota')
            <a href="{{ route('superadmin.gallery.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] hover:-translate-y-0.5 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Album
            </a>
        @endunlessrole
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($albums as $album)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 group">
                
                <div class="w-full aspect-[4/3] bg-slate-200 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ $album->thumbnail ? asset('storage/'.$album->thumbnail) : 'https://ui-avatars.com/api/?name='.urlencode($album->title).'&background=5442F5&color=fff&size=512' }}')">
                    
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                        <a href="{{ $album->drive_link }}" target="_blank" class="px-5 py-2.5 bg-white text-[#5442F5] rounded-xl font-bold text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2">
                            Buka Drive
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="p-5 relative">
                    <h3 class="font-extrabold text-slate-800 text-base leading-tight mb-2 line-clamp-2">{{ $album->title }}</h3>
                    
                    <div class="flex items-center justify-between mt-4 text-xs font-medium text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $album->activity_date ? \Carbon\Carbon::parse($album->activity_date)->format('d M Y') : '-' }}
                        </span>
                        
                        @unlessrole('Anggota')
                            <form action="{{ route('superadmin.gallery.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Hapus album ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors" title="Hapus Album">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endunlessrole
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-600 mb-1">Galeri Masih Kosong</h3>
                <p class="text-sm text-slate-400">Klik "Tambah Album" untuk memulai dokumentasi.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $albums->links() }}
    </div>
</div>
@endsection