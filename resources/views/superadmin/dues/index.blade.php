@extends('layouts.superadmin')
@section('title', 'Manajemen Jenis Iuran')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10" x-data="{ editMode: false, editId: null, editName: '', editType: 'Kas Rutin', editAmount: '', editDate: '', editDesc: '', editUrl: '' }">
    
    <!-- Header -->
    <div class="flex items-center gap-4 mb-2">
        <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Jenis Iuran & Tagihan</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Buat master tagihan baru. Sistem akan otomatis menagih ke seluruh anggota.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- KOLOM KIRI: Form Pembuatan Iuran -->
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 lg:sticky lg:top-6">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                <span class="w-2 h-4 bg-emerald-500 rounded-full"></span> 
                <span x-text="editMode ? 'Edit Tagihan' : 'Buat Tagihan Baru'"></span>
            </h3>
            
            <form :action="editMode ? editUrl : '{{ route('superadmin.finance.dues.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                <div x-show="!editMode">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode Akademik</label>
                    <select name="period_id" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Tagihan</label>
                    <input type="text" name="name" x-model="editName" required placeholder="Contoh: Uang Kas Bulan Juli" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis</label>
                        <select name="type" x-model="editType" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500">
                            <option value="Kas Rutin">Kas Rutin</option>
                            <option value="Iuran Kegiatan">Iuran Kegiatan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nominal (Rp)</label>
                        <input type="number" name="amount" x-model="editAmount" min="1000" required placeholder="20000" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Batas Waktu (Jatuh Tempo)</label>
                    <input type="date" name="due_date" x-model="editDate" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Catatan / Keterangan</label>
                    <textarea name="description" x-model="editDesc" rows="2" placeholder="Wajib dibayarkan sebelum acara..." class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <template x-if="editMode">
                        <button type="button" @click="editMode = false; editName = ''; editType = 'Kas Rutin'; editAmount = ''; editDate = ''; editDesc = '';" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold rounded-xl transition-colors">Batal</button>
                    </template>
                    <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-md transition-colors" x-text="editMode ? 'Simpan Perubahan' : 'Sebarkan Tagihan'"></button>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: Tabel Data Iuran -->
        <div class="lg:col-span-2 bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-[#F4F7FE]/50">
                <h3 class="font-bold text-slate-700">Daftar Tagihan Aktif</h3>
                <span class="text-xs font-bold text-slate-400">Total: {{ $dues->total() }} Tagihan</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Informasi Tagihan</th>
                            <th class="px-6 py-4">Batas Waktu</th>
                            <th class="px-6 py-4">Progress Dana</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                        @forelse ($dues as $due)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Kolom 1: Informasi Tagihan -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-sm mb-1">{{ $due->name }}</div>
                                <div class="flex items-center gap-2">
                                    <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-bold px-2 py-0.5 rounded">{{ $due->type }}</span>
                                    <span class="text-xs font-bold text-emerald-600">Rp {{ number_format($due->amount, 0, ',', '.') }}/org</span>
                                </div>
                            </td>

                            <!-- Kolom 2: Tanggal Jatuh Tempo -->
                            <td class="px-6 py-4">
                                @php 
                                    $isLate = \Carbon\Carbon::now()->startOfDay()->gt($due->due_date);
                                @endphp
                                <div class="font-bold {{ $isLate ? 'text-red-500' : 'text-slate-600' }}">
                                    {{ $due->due_date->format('d M Y') }}
                                </div>
                                @if($isLate)
                                    <div class="text-[10px] font-bold text-red-500 uppercase mt-1">Lewat Tempo</div>
                                @endif
                            </td>

                            <!-- Kolom 3: Progress Keuangan -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-sm">Rp {{ number_format($due->total_collected ?? 0, 0, ',', '.') }}</div>
                                <div class="text-[11px] font-medium text-slate-400 mt-0.5">{{ $due->lunas_count }} anggota lunas</div>
                            </td>

                            <!-- Kolom 4: Aksi -->
                            <td class="px-6 py-4 flex justify-end gap-2">
                                <!-- Tombol AlpineJS Edit -->
                                <button type="button" @click="editMode = true; editId = {{ $due->id }}; editName = '{{ addslashes($due->name) }}'; editType = '{{ $due->type }}'; editAmount = '{{ $due->amount }}'; editDate = '{{ $due->due_date->format('Y-m-d') }}'; editDesc = '{{ addslashes($due->description) }}'; editUrl = '{{ route('superadmin.finance.dues.update', $due->id) }}'" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Tagihan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                
                                <form action="{{ route('superadmin.finance.dues.destroy', $due->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus tagihan ini akan menghapus seluruh data SETORAN dan BUKTI BAYAR anggota untuk tagihan ini. Lanjutkan?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="block font-bold text-slate-500 mb-1">Belum Ada Tagihan</span>
                                Silakan buat jenis iuran baru melalui form di samping.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">{{ $dues->links() }}</div>
        </div>
    </div>
</div>
@endsection