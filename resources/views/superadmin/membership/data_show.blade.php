@extends('layouts.superadmin')
@section('title', 'Buku Induk - ' . ($member->name ?? 'Anggota'))

@section('content')
@php
    // =================================================================
    // LOGIKA BERSIH (DIJAMIN TIDAK ADA KATA CLONE SAMA SEKALI)
    // =================================================================
    $userId = $member->user_id ?? $member->id ?? 0;
    $mData = \Illuminate\Support\Facades\DB::table('members')->where('user_id', $userId)->first();
    
    // Ambil Data & Hindari Error jika Kosong
    $contact = $mData->emergency_contact ?? 'Belum diisi';
    $nimData = $mData->nim ?? $member->nim ?? 'NIM Tidak Tercatat';
    
    $skills = !empty($mData->skills) ? json_decode($mData->skills, true) : [];
    if (!is_array($skills)) $skills = [];

    $achievements = !empty($mData->achievements) ? json_decode($mData->achievements, true) : [];
    if (!is_array($achievements)) $achievements = [];
    
    $board_history = !empty($mData->board_history) ? json_decode($mData->board_history, true) : [];
    if (!is_array($board_history)) $board_history = [];
    
    $committee = !empty($mData->committee_history) ? json_decode($mData->committee_history, true) : [];
    if (!is_array($committee)) $committee = [];
@endphp

<div class="max-w-[1200px] mx-auto w-full flex flex-col gap-6 pb-10 pt-4">
    
    <a href="{{ route('superadmin.membership.data.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-[#5442F5] transition-colors w-max">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Database
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-[#5442F5] to-indigo-400"></div>
                <img src="{{ !empty($member->photo) ? asset('storage/'.$member->photo) : 'https://ui-avatars.com/api/?name='.urlencode($member->name ?? 'User').'&background=fff&color=5442F5' }}" class="w-28 h-28 mx-auto rounded-full border-4 border-white object-cover relative z-10 shadow-md mt-6 mb-4">
                
                <h2 class="text-xl font-black text-slate-800">{{ $member->name ?? 'Nama Tidak Diketahui' }}</h2>
                <p class="text-sm font-bold text-[#5442F5] mb-4">{{ $nimData }}</p>
                
                <div class="flex justify-center gap-2 mb-6">
                    @if(($member->status ?? 'Aktif') === 'Aktif')
                        <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1 rounded-full">Status: Aktif</span>
                    @else
                        <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-full">Status: Alumni/Inaktif</span>
                    @endif
                </div>

                <div class="text-left space-y-3 pt-4 border-t border-slate-100 text-sm">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Kontak Darurat</p>
                        <p class="font-medium text-slate-700">{{ $contact }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Keahlian (Skills)</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @if(count($skills) > 0)
                                @foreach($skills as $skill)
                                    <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-bold px-2 py-1 rounded-md">{{ $skill }}</span>
                                @endforeach
                            @else
                                <span class="text-slate-400 italic">Belum ada data keahlian.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="block text-center w-full py-3 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl shadow-md transition-colors">
                Edit Data Rekam Jejak (Form)
            </a>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-[30px] p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-50 text-[#5442F5] rounded-xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                    <h3 class="text-lg font-extrabold text-slate-800">Riwayat Kepengurusan</h3>
                </div>
                
                <div class="border-l-2 border-slate-100 pl-4 space-y-6 relative ml-2">
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-[#5442F5] ring-4 ring-indigo-50"></div>
                        <h4 class="font-bold text-slate-800 text-base">{{ $member->position ?? 'Anggota' }} - {{ $member->division->name ?? 'Lintas Divisi' }}</h4>
                        <p class="text-sm font-medium text-[#5442F5]">{{ $member->period->name ?? 'Periode Saat Ini' }}</p>
                    </div>

                    @if(count($board_history) > 0)
                        @foreach($board_history as $history)
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-slate-300 ring-4 ring-slate-50"></div>
                            <h4 class="font-bold text-slate-600 text-base">{{ $history['jabatan'] ?? '-' }} - {{ $history['divisi'] ?? '-' }}</h4>
                            <p class="text-sm font-medium text-slate-400">Periode {{ $history['tahun'] ?? '-' }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="text-amber-500">🏆</span> Prestasi & Sertifikasi</h3>
                    <ul class="space-y-3">
                        @if(count($achievements) > 0)
                            @foreach($achievements as $ach)
                                <li class="text-sm border-b border-slate-50 pb-2">
                                    <div class="font-bold text-slate-700">{{ is_array($ach) ? ($ach['nama'] ?? '-') : $ach }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ is_array($ach) ? ($ach['tingkat'] ?? 'Lainnya') : 'Lainnya' }} ({{ is_array($ach) ? ($ach['tahun'] ?? date('Y')) : date('Y') }})</div>
                                </li>
                            @endforeach
                        @else
                            <li class="text-sm text-slate-400 italic">Belum ada rekam prestasi.</li>
                        @endif
                    </ul>
                </div>

                <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="text-emerald-500">📋</span> Riwayat Kepanitiaan</h3>
                    <ul class="space-y-3">
                        @if(count($committee) > 0)
                            @foreach($committee as $com)
                                <li class="text-sm border-b border-slate-50 pb-2">
                                    <div class="font-bold text-slate-700">{{ is_array($com) ? ($com['acara'] ?? '-') : $com }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Sebagai: {{ is_array($com) ? ($com['jabatan'] ?? '-') : '-' }}</div>
                                </li>
                            @endforeach
                        @else
                            <li class="text-sm text-slate-400 italic">Belum ada rekam kepanitiaan.</li>
                        @endif
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection