@extends('layouts.superadmin')
@section('title', 'Struktur Panitia - ' . $proker->name)

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.prokers.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Workspace Panitia: {{ $proker->name }}</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelola kebutuhan kuota panitia, penunjukan langsung, dan validasi usulan nama.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="space-y-6 lg:col-span-1">
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <span class="w-2 h-4 bg-[#5442F5] rounded-full"></span> 1. Setup Divisi Panitia
                </h3>
                <form action="{{ route('superadmin.prokers.committee.storeRole', $proker->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Posisi / Divisi</label>
                        <input type="text" name="role_name" required placeholder="Contoh: Divisi Perlengkapan" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kuota Kebutuhan (Orang)</label>
                        <input type="number" name="quota" required min="1" value="1" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-colors">Tambah Kebutuhan</button>
                </form>
            </div>

            @if($committees->count() > 0)
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <span class="w-2 h-4 bg-[#5442F5] rounded-full"></span> 2. Tunjuk Anggota (BPH)
                </h3>
                <form action="{{ route('superadmin.prokers.committee.assignMember', $proker->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pilih Posisi / Divisi</label>
                        <select name="proker_committee_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
                            @foreach($committees as $com)
                                <option value="{{ $com->id }}">{{ $com->role_name }} (Sisa Slot: {{ $com->quota - $com->approvedMembersCount() }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Anggota HIMA</label>
                        <select name="user_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
                            <option value="">Cari nama mahasiswa...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#111111] hover:bg-black text-white text-sm font-bold rounded-xl shadow-md transition-colors">Sahkan Penunjukan</button>
                </form>
            </div>
            @endif
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 min-h-[400px]">
                <h3 class="font-bold text-slate-800 text-lg mb-6 border-b border-slate-100 pb-4">Struktur Pengisian Komponen Panitia</h3>
                
                @if($committees->count() == 0)
                    <div class="text-center py-20 text-slate-400 text-sm">Belum ada struktur kepanitiaan. Silakan isi form "Setup Divisi Panitia" terlebih dahulu.</div>
                @endif

                <div class="space-y-6">
                    @foreach($committees as $com)
                    @php 
                        $approvedCount = $com->approvedMembersCount();
                        $isFull = $approvedCount >= $com->quota;
                    @endphp
                    <div class="border border-slate-100 rounded-2xl p-5 bg-slate-50/50">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-base">{{ $com->role_name }}</h4>
                                <p class="text-xs font-medium {{ $isFull ? 'text-emerald-500' : 'text-amber-500' }} mt-0.5">
                                    Status Kebutuhan: {{ $approvedCount }}/{{ $com->quota }} Orang Terisi
                                </p>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $isFull ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $isFull ? 'Lengkap' : 'Kurang ' . ($com->quota - $approvedCount) . ' Pengurus' }}
                            </span>
                        </div>

                        <div class="w-full bg-slate-200 rounded-full h-2 mb-4">
                            <div class="h-2 rounded-full {{ $isFull ? 'bg-emerald-400' : 'bg-[#5442F5]' }}" style="width: {{ min(100, ($approvedCount / $com->quota) * 100) }}%"></div>
                        </div>

                        <div class="space-y-2 mt-4">
                            @foreach($com->members as $member)
                            <div class="bg-white rounded-xl p-3 border border-slate-100 flex justify-between items-center shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 font-bold text-xs flex items-center justify-center text-slate-600">
                                        {{ substr($member->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $member->user->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $member->user->email }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($member->status === 'Pending')
                                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md border border-amber-200">Diusulkan Kadiv</span>
                                        <form action="{{ route('superadmin.prokers.committee.approveMember', $member->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-lg transition-colors">ACC</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Sah Anggota</span>
                                    @endif

                                    <form action="{{ route('superadmin.prokers.committee.removeMember', $member->id) }}" method="POST" onsubmit="return confirm('Keluarkan anggota ini dari panitia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>
@endsection