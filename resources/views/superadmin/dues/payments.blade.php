@extends('layouts.superadmin')
@section('title', 'Data Pembayaran Iuran')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Pembayaran Iuran</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Verifikasi pengajuan bukti bayar, catat setoran manual, dan pantau histori kas masuk.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.finance.payments') }}" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-3 mb-2">
        
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa atau NIM..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
        
        <select name="due_id" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
            <option value="">Semua Tagihan</option>
            @foreach($dues as $due)
                <option value="{{ $due->id }}" {{ request('due_id') == $due->id ? 'selected' : '' }}>
                    {{ $due->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-40">
            <option value="">Semua Status</option>
            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
        </select>

        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Filter</button>
        
        @if(request()->anyFilled(['search', 'due_id', 'status']))
            <a href="{{ route('superadmin.finance.payments') }}" class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-bold transition-colors flex items-center justify-center" title="Reset Filter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        @endif
    </form>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-[#F4F7FE]/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-700 text-sm tracking-wide uppercase">Daftar Manifest Kas Masuk</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Mahasiswa (Pengurus)</th>
                        <th class="px-6 py-4">Jenis Tagihan</th>
                        <th class="px-6 py-4">Jumlah Bayar</th>
                        <th class="px-6 py-4">Metode & Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi Bendahara</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    @forelse($payments as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $p->user->name }}</div>
                            <div class="text-xs text-slate-400 font-medium mt-0.5">NIM: {{ $p->user->nim ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $p->due->name ?? 'Tagihan Terhapus' }}
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-800">
                            Rp {{ number_format($p->due?->amount ?? 0, 0, ',', '.') }}
                            <div class="text-[11px] text-slate-400 font-medium mt-0.5">Dari: Rp {{ number_format($p->due->amount ?? 0, 0, ',', '.') }}</div>
                        </td>

                        <td class="px-6 py-4 font-medium">
                            @if($p->status === 'Lunas')
                                <div class="text-slate-700 font-bold">{{ $p->payment_method ?? 'Manual' }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->format('d M Y, H:i') : '-' }}</div>
                            @else
                                <span class="text-slate-300 italic">Belum ada setor</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($p->status === 'Lunas')
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-extrabold px-3 py-1 rounded-md border border-emerald-100 block w-max">Lunas</span>
                            @else
                                <span class="bg-amber-50 text-amber-600 text-xs font-extrabold px-3 py-1 rounded-md border border-amber-100 block w-max">Belum Lunas</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            @if($p->status !== 'Lunas')
                                
                                <!-- Tombol Verifikasi HANYA terlihat oleh Super Admin dan BPH -->
                                @hasanyrole('Super Admin|BPH')
                                    <!-- Tombol Pemicu Modal -->
                                    <button type="button" onclick="openModal('modal-verify-{{ $p->id }}')" class="px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
                                        Sahkan Lunas
                                    </button>

                                    <!-- Struktur Modal Pop-up (Tersembunyi secara default) -->
                                    <div id="modal-verify-{{ $p->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                            
                                            <!-- Latar belakang gelap (Overlay) -->
                                            <div class="fixed inset-0 transition-opacity bg-slate-900/40 backdrop-blur-sm" aria-hidden="true" onclick="closeModal('modal-verify-{{ $p->id }}')"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            
                                            <!-- Panel Modal -->
                                            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                                                <form action="{{ route('superadmin.finance.payments.verify', $p->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="verify">
                                                    
                                                    <div class="px-6 pt-6 pb-4">
                                                        <h3 class="text-lg font-extrabold text-slate-800" id="modal-title">Sahkan Kas: {{ $p->user->name }}</h3>
                                                        <div class="mt-2 text-sm font-medium text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                                            <div class="flex justify-between mb-1">
                                                                <span>Tagihan:</span>
                                                                <span class="font-bold text-slate-700">{{ $p->due->name ?? 'Tagihan Terhapus' }}</span>
                                                            </div>
                                                            <div class="flex justify-between">
                                                                <span>Wajib Bayar:</span>
                                                                <span class="font-bold text-slate-700">Rp {{ number_format($p->due->amount ?? 0, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="mt-5 space-y-4">
                                                            <div>
                                                                <label class="block text-sm font-bold text-slate-700 mb-1.5 text-left">Nominal Diterima (Rp)</label>
                                                                <input type="number" name="amount_paid" value="{{ $p->due->amount ?? 0 }}" required class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-800 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5] shadow-inner transition-shadow text-left">
                                                                <p class="text-[11px] font-medium text-slate-400 mt-1.5 text-left">* Ubah nominal ini jika ada tambahan denda keterlambatan.</p>
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-bold text-slate-700 mb-1.5 text-left">Catatan / Keterangan (Opsional)</label>
                                                                <input type="text" name="notes" placeholder="Misal: Termasuk denda telat 1 minggu" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5] shadow-inner transition-shadow">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Footer Tombol -->
                                                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 rounded-b-2xl">
                                                        <button type="button" onclick="closeModal('modal-verify-{{ $p->id }}')" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Batal</button>
                                                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-500 rounded-xl hover:bg-emerald-600 shadow-sm transition-colors">Simpan Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Anggota dan Kadiv hanya melihat tombol Upload Bukti -->
                                    <button class="px-4 py-1.5 bg-[#5442F5] hover:bg-[#4331e5] text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
                                        Kirim Bukti Bayar
                                    </button>
                                @endhasanyrole

                            @else
                                <!-- JIKA STATUS SUDAH LUNAS -->
                                @hasanyrole('Super Admin|BPH')
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-emerald-500 font-bold text-xs flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terverifikasi
                                        </span>
                                        
                                        <!-- Tombol Pembatalan (Hanya BPH/Super Admin yang bisa lihat) -->
                                        <form action="{{ route('superadmin.finance.payments.verify', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan status lunas untuk {{ $p->user->name }}? Data setoran akan dikembalikan menjadi 0.');">
                                            @csrf
                                            <!-- Penanda Aksi Batal -->
                                            <input type="hidden" name="action" value="unverify">
                                            <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors" title="Batalkan Lunas (Revert)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Jika yang melihat Anggota biasa, cuma ada label tanpa tombol silang -->
                                    <div class="flex items-center justify-end text-emerald-500 font-bold text-xs gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terverifikasi
                                    </div>
                                @endhasanyrole
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">
                            Belum ada rekam transaksi iuran yang tercatat di database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<script>
    function openModal(modalID) {
        document.getElementById(modalID).classList.remove('hidden');
    }
    
    function closeModal(modalID) {
        document.getElementById(modalID).classList.add('hidden');
    }
</script>
@endsection