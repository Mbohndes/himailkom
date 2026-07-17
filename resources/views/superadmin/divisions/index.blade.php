@extends('layouts.superadmin')
@section('title', 'Manajemen Divisi')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Divisi</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelola daftar divisi dalam struktur organisasi HIMA.</p>
        </div>
        <a href="{{ route('superadmin.divisions.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md shadow-indigo-200 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Divisi
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
                        <th class="px-6 py-4">Nama Divisi</th>
                        <th class="px-6 py-4">Singkatan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse ($divisions as $divisi)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $divisi->name }}</td>
                        <td class="px-6 py-4 font-medium text-slate-500">{{ $divisi->abbreviation }}</td>
                        <td class="px-6 py-4">
                            @if($divisi->status === 'Aktif')
                                <span class="bg-[#2CE574]/20 text-[#14C95A] text-xs font-bold px-3 py-1.5 rounded-full">Aktif</span>
                            @else
                                <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1.5 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center justify-end gap-2">
                            <a href="{{ route('superadmin.divisions.edit', $divisi->id) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('superadmin.divisions.destroy', $divisi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus divisi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                            Belum ada data divisi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $divisions->links() }}
        </div>
    </div>
</div>
@endsection