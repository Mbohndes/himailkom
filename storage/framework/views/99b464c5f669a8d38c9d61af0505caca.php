
<?php $__env->startSection('title', 'Dashboard Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[30px] p-10 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-black mb-2">Pusat Laporan Organisasi</h1>
            <p class="text-slate-300 font-medium max-w-xl">Cetak dan unduh rekapitulasi data anggota, keuangan, progres kerja, hingga kearsipan untuk keperluan LPJ akhir periode.</p>
        </div>
        <svg class="absolute -top-10 -right-10 w-64 h-64 text-white opacity-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Total Rekam Anggota</p>
            <h3 class="text-3xl font-black text-[#5442F5]"><?php echo e($totalAnggota); ?></h3>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Purna Tugas (Alumni)</p>
            <h3 class="text-3xl font-black text-amber-500"><?php echo e($totalAlumni); ?></h3>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Sirkulasi Kas Masuk</p>
            <h3 class="text-2xl font-black text-emerald-500 mt-2">Rp <?php echo e(number_format($totalKas, 0, ',', '.')); ?></h3>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Dokumen Arsip</p>
            <h3 class="text-3xl font-black text-blue-500"><?php echo e($totalArsip); ?></h3>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/reports/index.blade.php ENDPATH**/ ?>