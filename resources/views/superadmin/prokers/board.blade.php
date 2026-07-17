@extends('layouts.superadmin')
@section('title', 'Task Board - ' . $proker->name)

@section('content')
<div x-data="{ showStageModal: false, showTaskModal: false, activeStageId: null }" class="h-full flex flex-col">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 pr-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.prokers.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Workspace: {{ $proker->name }}</h1>
            </div>
        </div>
        <!-- Tombol Tambah Tahapan Utama -->
        <button @click="showStageModal = true" class="px-5 py-2.5 bg-[#111111] hover:bg-black text-white rounded-xl font-bold text-sm shadow-md transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Tahapan
        </button>
    </div>

    <!-- TAB NAVIGASI WORKSPACE (Penting untuk pindah halaman tanpa Sidebar!) -->
    <div class="flex items-center gap-6 border-b border-slate-200 mb-6 pr-8">
        <a href="{{ route('superadmin.prokers.committee', $proker->id) }}" class="pb-3 text-sm font-bold text-slate-400 hover:text-[#5442F5] transition-colors border-b-2 border-transparent hover:border-[#5442F5]">
            1. Struktur Panitia
        </a>
        <a href="#" class="pb-3 text-sm font-bold text-[#5442F5] border-b-2 border-[#5442F5]">
            2. Papan Tugas (Kanban)
        </a>
        <!-- Nanti kita bisa tambah tab Anggaran dll di sini -->
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium mb-6 mr-8">{{ session('success') }}</div>
    @endif

    <!-- KANBAN BOARD AREA -->
    <div class="flex-1 overflow-x-auto pb-8 flex items-start gap-6 pr-8">
        
        @forelse($stages as $stage)
        <!-- KOLOM KANBAN -->
        <div class="w-80 flex-shrink-0 bg-slate-200/50 rounded-2xl flex flex-col max-h-full">
            
            <!-- Judul Kolom & Tombol Hapus -->
            <div class="p-4 flex items-center justify-between border-b border-slate-200/50">
                <div class="flex items-center gap-2">
                    <h3 class="font-bold text-slate-800">{{ $stage->name }}</h3>
                    <span class="bg-slate-200 text-slate-500 text-xs font-bold px-2 py-1 rounded-md">{{ $stage->tasks->count() }}</span>
                </div>
                <!-- Tombol Hapus Kolom -->
                <form action="{{ route('superadmin.prokers.stages.destroy', $stage->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kolom tahapan ini beserta seluruh tugas di dalamnya?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Daftar Kartu Tugas -->
            <div class="p-4 flex-1 overflow-y-auto space-y-3">
                @foreach($stage->tasks as $task)
                <div class="relative bg-white p-4 rounded-xl shadow-sm border border-slate-100 hover:border-[#5442F5] transition-colors group">
                    
                    <!-- Tombol Hapus Tugas (Muncul saat di-hover) -->
                    <form action="{{ route('superadmin.prokers.tasks.destroy', $task->id) }}" method="POST" class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Hapus tugas ini secara permanen?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-slate-300 hover:text-red-500 bg-red-50 rounded-lg p-1.5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>

                    <!-- Badge Prioritas -->
                    <div class="mb-2">
                        @if($task->priority == 'Mendesak')
                            <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Mendesak</span>
                        @elseif($task->priority == 'Tinggi')
                            <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Tinggi</span>
                        @elseif($task->priority == 'Sedang')
                            <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Sedang</span>
                        @else
                            <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Rendah</span>
                        @endif
                    </div>
                    
                    <h4 class="font-bold text-slate-700 text-sm mb-3 group-hover:text-[#5442F5] transition-colors pr-8">{{ $task->name }}</h4>
                    
                    <!-- Avatar Penerima Tugas -->
                    <div class="flex items-center gap-1">
                        @foreach($task->assignees as $assignee)
                            <div class="w-6 h-6 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-indigo-700 tooltip" title="{{ $assignee->user->name }}">
                                {{ substr($assignee->user->name, 0, 1) }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Tambah Tugas -->
            <div class="p-3">
                <button @click="activeStageId = {{ $stage->id }}; showTaskModal = true" class="w-full py-2 flex items-center justify-center gap-2 text-slate-500 hover:bg-slate-200/70 hover:text-slate-800 rounded-lg text-sm font-bold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Tugas
                </button>
            </div>
        </div>
        @empty
        <div class="w-full flex flex-col items-center justify-center py-20 text-slate-400">
            <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
            <p class="font-bold text-lg text-slate-500">Papan Proyek Masih Kosong</p>
            <button @click="showStageModal = true" class="px-4 py-2 mt-4 bg-[#5442F5] text-white rounded-lg text-sm font-bold">Buat Tahapan</button>
        </div>
        @endforelse
    </div>

    <!-- MODAL 1: Tambah Tahapan -->
    <div x-show="showStageModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showStageModal" @click="showStageModal = false" class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm"></div>
            <div x-show="showStageModal" class="relative w-full max-w-md p-8 text-left bg-white shadow-xl rounded-[30px]">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Tahapan Baru</h3>
                <form action="{{ route('superadmin.prokers.stages.store', $proker->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tahapan (Kolom)</label>
                        <input type="text" name="name" required placeholder="Contoh: Pra-Acara" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="showStageModal = false" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-[#5442F5] text-white rounded-xl font-bold text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Tambah Tugas -->
    <div x-show="showTaskModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showTaskModal" @click="showTaskModal = false" class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm"></div>
            <div x-show="showTaskModal" class="relative w-full max-w-lg p-8 text-left bg-white shadow-xl rounded-[30px]">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Buat Tugas Baru</h3>
                
                <form action="{{ route('superadmin.prokers.tasks.store', $proker->id) }}" method="POST">
                    @csrf
                    <!-- Input Tersembunyi untuk ID Tahapan -->
                    <input type="hidden" name="stage_id" x-bind:value="activeStageId">

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tugas</label>
                        <input type="text" name="name" required placeholder="Contoh: Pesan gedung A" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Prioritas</label>
                        <select name="priority" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3">
                            <option value="Rendah">Rendah (Low)</option>
                            <option value="Sedang" selected>Sedang (Medium)</option>
                            <option value="Tinggi">Tinggi (High)</option>
                            <option value="Mendesak">Mendesak (Urgent)</option>
                        </select>
                    </div>
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tugaskan ke Panitia</label>
                        <select name="assignees[]" multiple required class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 min-h-[100px]">
                            @forelse($panitia as $p)
                                <option value="{{ $p->user->id }}">{{ $p->user->name }}</option>
                            @empty
                                <option disabled>Belum ada panitia di-ACC.</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="showTaskModal = false" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-[#111111] text-white rounded-xl font-bold text-sm">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection