@extends('layouts.superadmin')
@section('title', 'Laporan Keaktifan Anggota')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 pb-10">
    
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Laporan Keaktifan Anggota</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Pemantauan persentase kehadiran pengurus dalam agenda pelaksanaan HIMA.</p>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
            <span>🖨️</span> Cetak Laporan
        </button>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-black text-slate-500 uppercase tracking-wider">
                        <th class="p-4 pl-6">Peringkat</th>
                        <th class="p-4">Nama Pengurus</th>
                        <th class="p-4 text-center">Total Kehadiran</th>
                        <th class="p-4">Persentase & Progress</th>
                        <th class="p-4 pr-6">Status Keaktifan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reportData as $index => $row)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Peringkat (Beri medali untuk top 3) -->
                            <td class="p-4 pl-6">
                                @if($index == 0) <span class="text-2xl">🥇</span>
                                @elseif($index == 1) <span class="text-2xl">🥈</span>
                                @elseif($index == 2) <span class="text-2xl">🥉</span>
                                @else <span class="text-sm font-black text-slate-400 ml-2">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            
                            <!-- Nama & Role -->
                            <td class="p-4">
                                <p class="text-sm font-black text-slate-800">{{ $row->name }}</p>
                                <p class="text-[11px] font-bold text-slate-400 mt-0.5">{{ $row->role }}</p>
                            </td>
                            
                            <!-- Total Hadir -->
    <td class="p-4 text-center">
        <span class="text-sm font-black text-slate-700">{{ $row->total_hadir }}</span>
        <span class="text-xs font-bold text-slate-400">/ {{ $row->total_agenda }} Agenda</span>
    </td>

                            <!-- Progress Bar Persentase -->
                            <td class="p-4 w-64">
                                <div class="flex items-center gap-3">
                                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $row->persentase >= 50 ? 'bg-[#14C95A]' : 'bg-[#F59E0B]' }}" style="width: {{ $row->persentase }}%;"></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-700 w-8">{{ $row->persentase }}%</span>
                                </div>
                            </td>

                            <!-- Label Keterangan -->
                            <td class="p-4 pr-6">
                                <span class="px-3 py-1 text-[11px] font-black uppercase tracking-wider rounded-lg border {{ $row->warna }}">
                                    {{ $row->keterangan }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-sm font-bold text-slate-400">
                                Belum ada data anggota atau agenda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sembunyikan Sidebar & Navbar saat diprint -->
<style>
    @media print {
        body * { visibility: hidden; }
        .max-w-\[1400px\], .max-w-\[1400px\] * { visibility: visible; }
        .max-w-\[1400px\] { position: absolute; left: 0; top: 0; width: 100%; padding: 0;}
        button { display: none !important; }
    }
</style>
@endsection