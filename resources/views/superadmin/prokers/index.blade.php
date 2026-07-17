@extends('layouts.superadmin')
@section('title', 'Data Program Kerja')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Program Kerja</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Daftar seluruh program kerja dari semua divisi HIMA.</p>
        </div>
        <a href="{{ route('superadmin.prokers.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md shadow-indigo-200 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Proker
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE] text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Kode & Nama Proker</th>
                        <th class="px-6 py-4">Divisi & PIC</th>
                        <th class="px-6 py-4">Jadwal Pelaksanaan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse ($prokers as $proker)
                    <tr class="hover:bg-slate-50 transition-colors">
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-base mb-0.5">{{ $proker->name }}</div>
                            <div class="text-xs font-semibold text-slate-400 bg-slate-100 inline-block px-2 py-0.5 rounded-md">
                                {{ $proker->program_code }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $proker->division->name ?? '-' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                PIC: {{ $proker->pic->name ?? '-' }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($proker->start_date)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                s.d {{ \Carbon\Carbon::parse($proker->end_date)->format('d M Y') }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($proker->status === 'Selesai')
                                <span class="bg-[#2CE574]/20 text-[#14C95A] text-xs font-bold px-3 py-1.5 rounded-full border border-[#2CE574]/30">Selesai</span>
                            @elseif($proker->status === 'Berjalan')
                                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200">Berjalan</span>
                            @elseif($proker->status === 'Terlambat')
                                <span class="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1.5 rounded-full border border-orange-200">Terlambat</span>
                            @elseif($proker->status === 'Dibatalkan')
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1.5 rounded-full border border-red-200">Dibatalkan</span>
                            @else
                                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-full border border-slate-200">Draft</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 flex items-center justify-end gap-2">
                            <!-- Tombol Manajemen Panitia (Baru ditambahkan) -->
                            <a href="{{ route('superadmin.prokers.committee', $proker->id) }}" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-colors" title="Manajemen Panitia & Tugas">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </a>

                            <!-- Tombol Edit Proker -->
                            <a href="{{ route('superadmin.prokers.edit', $proker->id) }}" class="p-2 text-[#5442F5] hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Proker">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <!-- Tombol Hapus Proker -->
                            <form action="{{ route('superadmin.prokers.destroy', $proker->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Program Kerja ini? Semua data terkait (Anggaran, LPJ) yang terhubung mungkin akan terdampak.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Proker">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Belum ada data program kerja.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
