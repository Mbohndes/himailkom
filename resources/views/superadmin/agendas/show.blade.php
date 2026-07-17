@extends('layouts.superadmin')
@section('title', 'Detail & Absensi Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center justify-between bg-white p-6 rounded-[30px] shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.agendas.index') }}" class="w-10 h-10 bg-slate-50 hover:bg-slate-100 rounded-full flex items-center justify-center text-slate-500 transition-colors">
                &larr;
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">{{ $agenda->title }}</h1>
                <p class="text-sm font-medium text-slate-400 mt-1">
                    📍 {{ $agenda->location }} &nbsp;|&nbsp; 🕒 {{ \Carbon\Carbon::parse($agenda->date_time)->format('d M Y, H:i') }}
                </p>
            </div>
        </div>
        <span class="px-4 py-2 rounded-xl text-sm font-bold bg-indigo-50 text-[#5442F5]">PIC: {{ $agenda->pic->name ?? 'Tidak Ada' }}</span>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 text-center">
            <p class="text-xs font-bold text-emerald-700 uppercase">Hadir</p>
            <h3 class="text-2xl font-black text-emerald-800">{{ $rekap['Hadir'] }}</h3>
        </div>
        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 text-center">
            <p class="text-xs font-bold text-blue-700 uppercase">Izin</p>
            <h3 class="text-2xl font-black text-blue-800">{{ $rekap['Izin'] }}</h3>
        </div>
        <div class="bg-amber-50 p-4 rounded-2xl border border-amber-100 text-center">
            <p class="text-xs font-bold text-amber-700 uppercase">Sakit</p>
            <h3 class="text-2xl font-black text-amber-800">{{ $rekap['Sakit'] }}</h3>
        </div>
        <div class="bg-red-50 p-4 rounded-2xl border border-red-100 text-center">
            <p class="text-xs font-bold text-red-700 uppercase">Alfa</p>
            <h3 class="text-2xl font-black text-red-800">{{ $rekap['Alfa'] }}</h3>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center">
            <p class="text-xs font-bold text-slate-500 uppercase">Belum Absen</p>
            <h3 class="text-2xl font-black text-slate-700">{{ $rekap['Belum Absen'] }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-extrabold text-slate-800">Daftar Kehadiran Peserta</h3>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F4F7FE] text-slate-400 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4">Nama Peserta</th>
                    <th class="px-6 py-4">Status Saat Ini</th>
                    <th class="px-6 py-4 text-center">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($agenda->attendances as $absen)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $absen->user->name ?? 'Anonim' }}</td>
                    <td class="px-6 py-4">
                        @php
                            $color = match($absen->status) {
                                'Hadir' => 'bg-emerald-100 text-emerald-700',
                                'Izin' => 'bg-blue-100 text-blue-700',
                                'Sakit' => 'bg-amber-100 text-amber-700',
                                'Alfa' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-600',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $color }}">{{ $absen->status }}</span>
                    </td>
                    
                    <td class="px-6 py-4 text-right">
                        
                        @unlessrole('Anggota')
                            <form action="{{ route('superadmin.agendas.updateAttendance', $agenda->id) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $absen->user_id }}">
                                <select name="status" class="bg-slate-50 border border-slate-200 text-xs rounded-lg px-2 py-1 focus:ring-[#5442F5]">
                                    <option value="Hadir" {{ $absen->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ $absen->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ $absen->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="Alfa" {{ $absen->status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                                </select>
                                <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-bold rounded-lg transition-colors">
                                    Simpan
                                </button>
                            </form>
                        @else
                            <span class="text-xs font-bold text-slate-400 italic">Akses Terbatas</span>
                        @endunlessrole

                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400">Belum ada peserta yang diundang ke agenda ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection