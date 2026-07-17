@extends('layouts.superadmin')
@section('title', 'Data Pemasukan')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Pemasukan</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Catat dana masuk dari sponsor, fakultas, dan lainnya.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="px-6 py-3 bg-[#14C95A] text-white font-bold rounded-2xl shadow-lg hover:bg-emerald-600 transition-all">
            + Tambah Pemasukan
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
    @endif

   <form method="GET" action="{{ route('superadmin.finance.incomes.index') }}" class="w-full">
    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        
        <!-- Label Filter -->
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="text-sm font-bold text-slate-600">Filter Pemasukan:</span>
        </div>
        
        <!-- Elemen Input & Kontrol -->
        <div class="flex flex-wrap gap-3 items-center w-full sm:w-auto justify-end">
            
            <!-- Filter Bulan -->
            <div class="relative min-w-[140px]">
                <select name="month" onchange="this.form.submit()" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-600 rounded-xl pl-4 pr-10 py-2.5 focus:ring-0 cursor-pointer appearance-none">
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
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Filter Tahun -->
            <div class="relative min-w-[120px]">
                <select name="year" onchange="this.form.submit()" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-600 rounded-xl pl-4 pr-10 py-2.5 focus:ring-0 cursor-pointer appearance-none">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Tombol Reset -->
            @if(request('month') || request('year'))
                <a href="{{ route('superadmin.finance.incomes.index') }}" class="text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap h-[40px] flex items-center">
                    Reset
                </a>
            @endif
        </div>
    </div>
</form>


    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F4F7FE] text-slate-400 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4">Sumber Dana</th>
                    <th class="px-6 py-4">Deskripsi</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Dicatat Oleh</th>
                    <th class="px-6 py-4 text-center">Aksi</th> </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($incomes as $inc)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-bold text-[#5442F5]">{{ $inc->source }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $inc->description }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($inc->date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold text-[#14C95A]">Rp {{ number_format($inc->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $inc->user->name ?? 'Admin' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="document.getElementById('modal-edit-{{ $inc->id }}').classList.remove('hidden')" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('superadmin.finance.incomes.destroy', $inc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pemasukan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div id="modal-edit-{{ $inc->id }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-3xl p-8 w-full max-w-md text-left">
                        <h2 class="text-xl font-bold mb-4 text-slate-800">Edit Pemasukan</h2>
                        <form action="{{ route('superadmin.finance.incomes.update', $inc->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Sumber Dana</label>
                                    <select name="source" class="w-full rounded-xl border-slate-200 text-slate-700" required>
                                        <option value="Sponsorship" {{ $inc->source == 'Sponsorship' ? 'selected' : '' }}>Sponsorship</option>
                                        <option value="Dana Fakultas" {{ $inc->source == 'Dana Fakultas' ? 'selected' : '' }}>Dana Fakultas</option>
                                        <option value="Donasi Alumni" {{ $inc->source == 'Donasi Alumni' ? 'selected' : '' }}>Donasi Alumni</option>
                                        <option value="Penjualan Merchandise" {{ $inc->source == 'Penjualan Merchandise' ? 'selected' : '' }}>Penjualan Merchandise</option>
                                        <option value="Hasil Usaha / Danus" {{ $inc->source == 'Hasil Usaha / Danus' ? 'selected' : '' }}>Hasil Usaha / Danus</option>
                                        <option value="Lainnya" {{ $inc->source == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Deskripsi</label>
                                    <input type="text" name="description" value="{{ $inc->description }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Jumlah (Rp)</label>
                                    <input type="number" name="amount" value="{{ intval($inc->amount) }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 block mb-1">Tanggal Transaksi</label>
                                    <input type="date" name="date" value="{{ $inc->date }}" class="w-full rounded-xl border-slate-200" required>
                                </div>
                                <div class="flex gap-3 mt-4">
                                    <button type="button" onclick="document.getElementById('modal-edit-{{ $inc->id }}').classList.add('hidden')" class="flex-1 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                                    <button type="submit" class="flex-1 py-2 rounded-xl bg-[#14C95A] text-white font-bold">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada data pemasukan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $incomes->links() }}</div>
    </div>
</div>

<div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Pemasukan</h2>
        <form action="{{ route('superadmin.finance.incomes.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <select name="source" class="w-full rounded-xl border-slate-200 text-slate-700" required>
                    <option value="">-- Pilih Sumber Dana --</option>
                    <option value="Sponsorship">Sponsorship</option>
                    <option value="Dana Fakultas">Dana Fakultas / Universitas</option>
                    <option value="Donasi Alumni">Donasi Alumni</option>
                    <option value="Penjualan Merchandise">Penjualan Merchandise</option>
                    <option value="Hasil Usaha / Danus">Hasil Usaha / Danus</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input type="text" name="description" placeholder="Deskripsi (Contoh: Sponsor PT XYZ)" class="w-full rounded-xl border-slate-200" required>
                <input type="number" name="amount" placeholder="Jumlah (Contoh: 1500000)" class="w-full rounded-xl border-slate-200" required>
                <input type="date" name="date" class="w-full rounded-xl border-slate-200" required>
                <div class="flex gap-3 mt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="flex-1 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">Batal</button>
                    <button type="submit" class="flex-1 py-2 rounded-xl bg-[#14C95A] hover:bg-emerald-600 text-white font-bold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection