@extends('layouts.superadmin')
@section('title', 'Laporan Keuangan Kas')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Laporan Buku Kas & Iuran</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Rekapitulasi otomatis arus keuangan, akumulasi saldo, dan kepatuhan iuran sub-periode.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Kas Masuk (Iuran)</p>
            <h3 class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pengeluaran</p>
            <h3 class="text-2xl font-black text-red-500">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-6 rounded-[24px] border border-indigo-100 shadow-sm">
            <p class="text-[#5442F5] text-xs font-bold uppercase tracking-wider mb-1">Sisa Saldo Kas HIMA</p>
            <h3 class="text-2xl font-black text-indigo-700">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[30px] shadow-sm border border-slate-100">
        <form action="{{ route('superadmin.reports.finance') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode Jabatan</label>
                <select name="period_id" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ request('period_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Bulan Transaksi</label>
                <select name="month" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tahun Buku</label>
                <select name="year" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">Filter Buku</button>
                @if(request()->anyFilled(['period_id', 'month', 'year']))
                    <a href="{{ route('superadmin.reports.finance') }}" class="py-2.5 px-4 bg-red-50 text-red-600 rounded-xl text-sm font-bold transition-colors">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-[#F4F7FE]/50">
            <div>
                <h3 class="font-bold text-slate-700 uppercase tracking-wide text-sm">Jurnal Transaksi Kas Masuk</h3>
                <p class="text-xs font-medium text-slate-500 mt-0.5 font-mono">Audit trail untuk data pembayaran valid.</p>
            </div>
            <a href="{{ route('superadmin.reports.finance', array_merge(request()->all(), ['export' => 'print'])) }}" target="_blank" class="px-5 py-2 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Lembar Keuangan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Tanggal Validasi</th>
                        <th class="px-6 py-4">Nama Mahasiswa (Penyetor)</th>
                        <th class="px-6 py-4">Keterangan Tagihan</th>
                        <th class="px-6 py-4">Metode</th>
                        <th class="px-6 py-4 text-right">Jumlah Setoran</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    @forelse($payments as $pay)
                    <tr class="hover:bg-slate-50/40">
                        <td class="px-6 py-4 font-mono text-xs text-slate-500">
                            {{ $pay->paid_at ? $pay->paid_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $pay->user->name }}</div>
                            <div class="text-xs text-slate-400 font-medium">NIM: {{ $pay->user->nim ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $pay->due->name }} 
                            <span class="text-xs font-bold text-slate-400 block mt-0.5">Masa Jabatan: {{ $pay->due->period->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-xs text-slate-500 uppercase">
                            {{ $pay->payment_method ?? 'Manual' }}
                        </td>
                        <td class="px-6 py-4 text-right font-black text-emerald-600 text-base">
                            + Rp {{ number_format($pay->amount_paid, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">Tidak ada rekam mutasi kas masuk yang cocok dengan kriteria filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection