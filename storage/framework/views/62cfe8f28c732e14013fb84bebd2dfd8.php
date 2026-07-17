
<?php $__env->startSection('title', 'Laporan Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Laporan Keanggotaan</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Filter, urutkan, dan cetak data keanggotaan berdasarkan parameter spesifik.</p>
    </div>

    <!-- FILTER GLOBAL -->
    <div class="bg-white p-6 rounded-[30px] shadow-sm border border-slate-100">
        <form action="<?php echo e(route('superadmin.reports.members')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode HIMA</label>
                <select name="period_id" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Periode</option>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e(request('period_id') == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Divisi</label>
                <select name="division_id" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Divisi</option>
                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->id); ?>" <?php echo e(request('division_id') == $d->id ? 'selected' : ''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status / Peran</label>
                <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Data</option>
                    <option value="Aktif" <?php echo e(request('status') == 'Aktif' ? 'selected' : ''); ?>>Anggota Aktif</option>
                    <option value="Pengurus" <?php echo e(request('status') == 'Pengurus' ? 'selected' : ''); ?>>Hanya Pengurus</option>
                    <option value="Nonaktif" <?php echo e(request('status') == 'Nonaktif' ? 'selected' : ''); ?>>Alumni / Purna</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tahun Angkatan</label>
                <input type="number" name="cohort" value="<?php echo e(request('cohort')); ?>" placeholder="Cth: 2024" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Terapkan</button>
                <?php if(request()->anyFilled(['period_id', 'division_id', 'status', 'cohort'])): ?>
                    <a href="<?php echo e(route('superadmin.reports.members')); ?>" class="py-2.5 px-4 bg-red-50 text-red-600 rounded-xl text-sm font-bold transition-colors">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- TOMBOL EXPORT & HASIL TABEL -->
    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-[#F4F7FE]/50">
            <div>
                <h3 class="font-bold text-slate-700 uppercase tracking-wide text-sm">Hasil Rekapitulasi Data</h3>
                <p class="text-xs font-medium text-slate-500 mt-0.5">Ditemukan: <?php echo e($members->count()); ?> baris data.</p>
            </div>
            <div class="flex gap-2">
                <!-- Tombol Print / PDF Cerdas -->
                <a href="<?php echo e(route('superadmin.reports.members', array_merge(request()->all(), ['export' => 'print']))); ?>" target="_blank" class="px-5 py-2 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak & Simpan PDF
                </a>
                <button onclick="alert('Fitur Excel membutuhkan package maatwebsite/excel. Silakan instal terlebih dahulu.')" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Nama Mahasiswa</th>
                        <th class="px-6 py-4">NIM / Angkatan</th>
                        <th class="px-6 py-4">Divisi & Jabatan</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/40">
                        <td class="px-6 py-4 font-bold text-slate-400"><?php echo e($index + 1); ?></td>
                        <td class="px-6 py-4 font-bold text-slate-800"><?php echo e($m->name); ?></td>
                        <td class="px-6 py-4"><?php echo e($m->nim ?? '-'); ?> / <span class="font-bold text-[#5442F5]"><?php echo e($m->profile->entry_year ?? '-'); ?></span></td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700"><?php echo e($m->division->name ?? 'Lintas Divisi'); ?></span> <br>
                            <span class="text-xs text-slate-400"><?php echo e($m->position ?? 'Anggota Biasa'); ?></span>
                        </td>
                        <td class="px-6 py-4"><?php echo e($m->status); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">Data tidak ditemukan untuk filter ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/reports/members.blade.php ENDPATH**/ ?>