
<?php $__env->startSection('title', 'Dashboard Keuangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-10 pb-10">
    
    <!-- HEADER -->
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Dashboard Keuangan HIMA</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Ikhtisar sirkulasi dana, rekapitulasi penagihan, dan statistik kepatuhan pembayaran.</p>
    </div>

    <!-- ========================================= -->
    <!-- BAGIAN 1: ARUS KAS GLOBAL & SALDO AKHIR -->
    <!-- ========================================= -->
    <div class="flex flex-col gap-6">
        
        <!-- KARTU UTAMA: SALDO AKHIR -->
        <div class="bg-gradient-to-r from-[#5442F5] to-indigo-800 rounded-[32px] p-8 md:p-10 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative z-10">
                <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-2">Total Saldo Akhir Organisasi</p>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight">Rp <?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></h2>
                <div class="flex items-center gap-2 mt-3">
                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Real-time</span>
                    <span class="text-indigo-200 text-xs font-medium">Data dihitung dari seluruh transaksi aktif.</span>
                </div>
            </div>
            
            <div class="relative z-10 w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center border border-white/20 hidden md:flex">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            
            <svg class="absolute -bottom-10 -right-10 w-64 h-64 text-white opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
        </div>

        <!-- 3 KARTU METRIK RINCIAN GLOBAL -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-[#14C95A]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Iuran Masuk (Lunas)</p>
                    <h3 class="text-xl font-black text-slate-800">Rp <?php echo e(number_format($totalIuranMasuk, 0, ',', '.')); ?></h3>
                </div>
            </div>

            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-[#5442F5]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pemasukan Umum</p>
                    <h3 class="text-xl font-black text-slate-800">Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></h3>
                </div>
            </div>

            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-[#FF4D4D]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pengeluaran</p>
                    <h3 class="text-xl font-black text-slate-800">Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></h3>
                </div>
            </div>
        </div>
    </div>


    <!-- ========================================= -->
    <!-- BAGIAN 2: ANALISIS KEPATUHAN IURAN -->
    <!-- ========================================= -->
    <div>
        <h2 class="text-xl font-extrabold text-slate-800 mb-6">Analisis Kepatuhan Iuran</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold">🎯</span>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Target Tagihan</p>
                </div>
                <p class="text-sm text-slate-400 font-medium mb-1">Total Target Ketetapan</p>
                <h3 class="text-3xl font-black text-slate-800">Rp <?php echo e(number_format($totalTarget, 0, ',', '.')); ?></h3>
            </div>
            
            <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-6 rounded-[24px] border border-emerald-100 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-700 flex items-center justify-center font-bold">💰</span>
                    <p class="text-emerald-700 text-xs font-bold uppercase tracking-wider">Realisasi</p>
                </div>
                <p class="text-sm text-emerald-600/80 font-medium mb-1">Total Kas Terkumpul</p>
                <h3 class="text-3xl font-black text-emerald-700">Rp <?php echo e(number_format($totalIuranMasuk, 0, ',', '.')); ?></h3>
            </div>
            
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-[24px] border border-amber-100 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-full bg-amber-200 text-amber-700 flex items-center justify-center font-bold">⏳</span>
                    <p class="text-amber-700 text-xs font-bold uppercase tracking-wider">Tunggakan</p>
                </div>
                <p class="text-sm text-amber-600/80 font-medium mb-1">Transaksi Belum Lunas</p>
                <h3 class="text-3xl font-black text-amber-700"><?php echo e($totalTunggakan); ?> <span class="text-lg font-bold text-amber-600">Transaksi</span></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-[30px] p-8 border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center h-full min-h-[350px]">
                <h3 class="font-bold text-slate-800 text-lg mb-6">Rasio Kolektibilitas Dana</h3>
                <div class="relative w-44 h-44 flex items-center justify-center mb-6">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-100" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                        <path class="text-[#2CE574] transition-all duration-1000 ease-out" stroke-dasharray="<?php echo e($rasioKolektibilitas); ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                    <div class="absolute text-5xl font-black text-slate-800 tracking-tighter"><?php echo e($rasioKolektibilitas); ?><span class="text-2xl">%</span></div>
                </div>
                <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-sm">
                    Persentase dana riil terkumpul dibandingkan target keseluruhan ketetapan iuran aktif.
                </p>
            </div>

            <div class="bg-gradient-to-br from-[#1E293B] to-slate-800 rounded-[30px] p-8 shadow-xl shadow-slate-200/50 text-white relative overflow-hidden h-full flex flex-col justify-between min-h-[350px]">
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6 border border-white/10">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-2xl mb-3">Manajemen Iuran Terpusat</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-8 pr-4">
                        Seluruh data pembayaran iuran mahasiswa terekam secara otomatis ke dalam sistem audit trail. Pastikan untuk selalu memantau tunggakan anggota secara berkala.
                    </p>
                    
                    <div class="flex items-end justify-between border-t border-white/10 pt-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Wajib Iuran Aktif</p>
                            <h4 class="text-3xl font-black"><?php echo e($totalAnggota); ?> <span class="text-lg font-bold text-slate-300">Jiwa</span></h4>
                        </div>
                        <a href="<?php echo e(route('superadmin.finance.payments')); ?>" class="px-6 py-3 bg-white text-slate-800 hover:bg-slate-100 hover:scale-105 active:scale-95 rounded-xl text-sm font-extrabold shadow-lg transition-all flex items-center gap-2 whitespace-nowrap">
                            Kelola Tagihan &rarr;
                        </a>
                    </div>
                </div>
                <svg class="absolute -bottom-10 -right-10 w-64 h-64 text-white opacity-5 pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
        </div>
    </div>


    <!-- ========================================= -->
    <!-- BAGIAN 3: RIWAYAT TRANSAKSI UMUM -->
    <!-- ========================================= -->
    <div>
        <h2 class="text-xl font-extrabold text-slate-800 mb-6 mt-4">Riwayat Transaksi Umum Terbaru</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Pemasukan Terbaru -->
            <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm p-7">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Pemasukan Umum</h3>
                    <a href="<?php echo e(route('superadmin.finance.incomes.index')); ?>" class="text-xs font-bold text-[#5442F5] hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $recentIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-[#14C95A]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800"><?php echo e($inc->source); ?></h4>
                                    <p class="text-xs text-slate-400 font-medium"><?php echo e(\Carbon\Carbon::parse($inc->date)->format('d M Y')); ?></p>
                                </div>
                            </div>
                            <span class="font-bold text-[#14C95A] text-sm">+ Rp <?php echo e(number_format($inc->amount, 0, ',', '.')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada pemasukan umum.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pengeluaran Terbaru -->
            <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm p-7">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Pengeluaran Organisasi</h3>
                    <a href="<?php echo e(route('superadmin.finance.expenses.index')); ?>" class="text-xs font-bold text-[#5442F5] hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $recentExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-[#FF4D4D]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800"><?php echo e($ex->description); ?></h4>
                                    <p class="text-xs text-slate-400 font-medium"><?php echo e(\Carbon\Carbon::parse($ex->date)->format('d M Y')); ?></p>
                                </div>
                            </div>
                            <span class="font-bold text-[#FF4D4D] text-sm">- Rp <?php echo e(number_format($ex->amount, 0, ',', '.')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada pengeluaran.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/dues/dashboard.blade.php ENDPATH**/ ?>