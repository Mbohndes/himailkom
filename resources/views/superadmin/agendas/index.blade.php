@extends('layouts.superadmin')
@section('title', 'Daftar Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Agenda Organisasi</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Jadwal kegiatan internal, rapat, dan evaluasi HIMA.</p>
        </div>
        
        @unlessrole('Anggota')
        <a href="{{ route('superadmin.agendas.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Agenda Baru
        </a>
        @endunlessrole
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex gap-4">
        <form action="{{ route('superadmin.agendas.index') }}" method="GET" class="flex gap-4 w-full">
            <select name="category" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">
                <option value="">Semua Kategori</option>
                <option value="Rapat" {{ request('category') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                <option value="Musyawarah" {{ request('category') == 'Musyawarah' ? 'selected' : '' }}>Musyawarah</option>
                <option value="Evaluasi" {{ request('category') == 'Evaluasi' ? 'selected' : '' }}>Evaluasi</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-slate-800 text-white rounded-xl text-sm font-bold">Filter</button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($agendas as $agenda)
        <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-100 hover:border-[#5442F5] transition-colors flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $agenda->category }}</span>
                    @if($agenda->status == 'Terjadwal')
                        <span class="text-amber-500 flex items-center gap-1 text-xs font-bold"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Segera</span>
                    @elseif($agenda->status == 'Selesai')
                        <span class="text-emerald-500 flex items-center gap-1 text-xs font-bold"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Selesai</span>
                    @endif
                </div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $agenda->title }}</h3>
                
                <div class="space-y-2 mt-4">
                    <div class="flex items-center gap-3 text-sm text-slate-500 font-medium">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($agenda->date_time)->translatedFormat('l, d M Y - H:i') }} WIB
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-500 font-medium">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $agenda->location }}
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-400 font-medium">PIC: <span class="text-slate-700 font-bold">{{ $agenda->pic->name ?? 'Anonim' }}</span></div>
                
                <div class="flex items-center gap-1.5">
                    
                    @unlessrole('Anggota')
                        <a href="{{ route('superadmin.agendas.edit', $agenda->id) }}" title="Edit Agenda" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        
                        <form action="{{ route('superadmin.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus Agenda" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    @endunlessrole

                    <a href="{{ route('superadmin.agendas.show', $agenda->id) }}" title="Lihat Detail & Absensi" class="p-2 bg-[#F4F7FE] text-[#5442F5] hover:bg-[#5442F5] hover:text-white rounded-lg transition-colors ml-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Tidak ada agenda yang dijadwalkan.
        </div>
        @endforelse
    </div>
    
    <div class="mt-4">{{ $agendas->links() }}</div>
</div>
@endsection