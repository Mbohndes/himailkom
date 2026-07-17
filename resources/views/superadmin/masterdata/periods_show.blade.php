@extends('layouts.superadmin')
@section('title', 'Detail Periode - ' . $period->name)

@section('content')
<div class="max-w-[1000px] mx-auto w-full flex flex-col gap-6 pb-10 pt-4">
    
    <a href="{{ route('superadmin.masterdata.periods.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-[#5442F5] w-max">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Periode
    </a>

    <!-- Header Banner -->
    <div class="bg-gradient-to-br from-[#5442F5] to-indigo-800 rounded-[30px] p-10 text-white relative overflow-hidden shadow-xl shadow-indigo-200">
        <div class="relative z-10 text-center">
            @if($period->status === 'Aktif')
                <span class="inline-block bg-emerald-400 text-slate-900 text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full mb-4">Sedang Menjabat</span>
            @endif
            <h1 class="text-4xl font-black mb-2">{{ $period->name }}</h1>
            <p class="text-indigo-200 font-bold text-lg mb-6">{{ $period->start_year }} - {{ $period->end_year }}</p>
            
            @if($period->theme)
                <div class="inline-block bg-white/20 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20">
                    <p class="text-sm font-medium text-indigo-100 uppercase tracking-widest text-[10px] mb-1">Tema / Tagline</p>
                    <p class="font-bold text-xl">"{{ $period->theme }}"</p>
                </div>
            @endif
        </div>
        <svg class="absolute -bottom-10 -right-10 w-64 h-64 text-white opacity-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
    </div>

    <!-- Visi Misi & Info Tambahan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm">
                <h3 class="font-extrabold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-indigo-50 text-[#5442F5] flex items-center justify-center">🎯</span> Visi Utama
                </h3>
                <p class="text-slate-600 leading-relaxed font-medium">
                    {{ $period->vision ?? 'Visi belum dirumuskan.' }}
                </p>
            </div>
            
            <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm">
                <h3 class="font-extrabold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">🚀</span> Misi Organisasi
                </h3>
                <div class="prose prose-sm text-slate-600 font-medium">
                    {!! nl2br(e($period->mission)) ?? 'Misi belum dijabarkan.' !!}
                </div>
            </div>
        </div>

        <div class="md:col-span-1 space-y-6">
            <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm text-center">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Anggota</h4>
                <div class="text-4xl font-black text-[#5442F5]">{{ $memberCount }}</div>
                <p class="text-xs font-medium text-slate-500 mt-1">Personel ditempatkan di periode ini</p>
            </div>

            <div class="bg-white rounded-[30px] p-6 border border-slate-100 shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-100 pb-2">Detail Kalender</h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Mulai Menjabat</p>
                        <p class="text-sm font-bold text-slate-700">{{ $period->start_date ? $period->start_date->format('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Akhir Jabatan</p>
                        <p class="text-sm font-bold text-slate-700">{{ $period->end_date ? $period->end_date->format('d F Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection