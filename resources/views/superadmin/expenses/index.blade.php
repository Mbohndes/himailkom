@extends('layouts.superadmin')
@section('title', 'Data Pengeluaran')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Pengeluaran</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Catat dan pantau semua pengeluaran organisasi.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="px-6 py-3 bg-[#FF4D4D] text-white font-bold rounded-2xl shadow-lg hover:bg-red-600 transition-all">
            + Tambah Pengeluaran
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex flex-wrap gap-4 items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <span class="text-sm font-bold text-slate-600">Filter Pengeluaran:</span>
        </div>
        <form method="GET" action="{{ route('superadmin.finance.expenses.index') }}" class="flex gap-3 items-center">
            
            <select name="month" onchange="this.form.submit()" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-600 rounded-xl px-4 py-2 focus:ring-0 cursor-pointer">
                <option value="">Semua Bulan</option>
                <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>Januari</option>
                <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>Februari</option>
                <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>Maret</option>
                <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>Juni</option>
                <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>Juli</option>
                <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>Agustus</option>
                <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
            </select>

            <select name="year" onchange="this.form.submit()" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-600 rounded-xl px-4 py-2 focus:ring-0 cursor-pointer">
                <option value="">Semua Tahun</option>
                @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            @if(request('month') || request('year'))
                <a href="{{ route('superadmin.finance.expenses.index') }}" class="text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2.5 rounded-xl transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F4F7FE] text-slate-400 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4">Deskripsi</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Dicatat Oleh</th>
                    <th class="px-6 py-4 text-center">Aksi</th> </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($expenses as $ex)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $ex->description }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($ex->date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold text-red-600">Rp {{ number_format($ex->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $ex->user->name ?? 'Admin' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="document.getElementById('modal-edit-{{ $ex->id }}').classList.remove('hidden')" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('superadmin.finance.expenses.destroy', $ex->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengeluaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div id="modal-edit-{{ $ex->id }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-3xl p-8 w-full max-w-md text-left">
                        <h2 class="text-xl font-bold mb-4 text-slate-800">Edit Pengeluaran</h2>
                        <form action="{{ route('superadmin.finance.expenses.update', $ex->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Keperluan / Deskripsi</label>
                                    <input type="text" name="description" value="{{ $ex->description }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Jumlah (Rp)</label>
                                    <input type="number" name="amount" value="{{ intval($ex->amount) }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Tanggal Transaksi</label>
                                    <input type="date" name="date" value="{{ $ex->date }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div class="flex gap-3 mt-4">
                                    <button type="button" onclick="document.getElementById('modal-edit-{{ $ex->id }}').classList.add('hidden')" class="flex-1 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                                    <button type="submit" class="flex-1 py-2 rounded-xl bg-[#5442F5] text-white font-bold">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada data pengeluaran.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $expenses->links() }}</div>
    </div>
</div>

<div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Pengeluaran</h2>
        <form action="{{ route('superadmin.finance.expenses.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <input type="text" name="description" placeholder="Keperluan (Contoh: Beli Kertas)" class="w-full rounded-xl border-slate-200" required>
                <input type="number" name="amount" placeholder="Jumlah (Contoh: 50000)" class="w-full rounded-xl border-slate-200" required>
                <input type="date" name="date" class="w-full rounded-xl border-slate-200" required>
                <div class="flex gap-3 mt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="flex-1 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">Batal</button>
                    <button type="submit" class="flex-1 py-2 rounded-xl bg-[#5442F5] hover:bg-indigo-700 text-white font-bold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection