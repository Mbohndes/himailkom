
<?php $__env->startSection('title', 'Laporan Program Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Laporan Program Kerja</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Audit perkembangan kerja, persentase ketercapaian target, dan evaluasi program HIMA.</p>
    </div>

    <div class="bg-white p-6 rounded-[30px] shadow-sm border border-slate-100">
        <form action="<?php echo e(route('superadmin.reports.programs')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode Organisasi</label>
                <select name="period_id" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Periode</option>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e(request('period_id') == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Divisi Pelaksana</label>
                <select name="division_id" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Divisi</option>
                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->id); ?>" <?php echo e(request('division_id') == $d->id ? 'selected' : ''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status Capaian</label>
                <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                    <option value="">Semua Status</option>
                    <option value="Selesai" <?php echo e(request('status') == 'Selesai' ? 'selected' : ''); ?>>Program Selesai</option>
                    <option value="Berjalan" <?php echo e(request('status') == 'Berjalan' ? 'selected' : ''); ?>>Program Berjalan</option>
                    <option value="Terlambat" <?php echo e(request('status') == 'Terlambat' ? 'selected' : ''); ?>>Program Terlambat</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Saring</button>
                <?php if(request()->anyFilled(['period_id', 'division_id', 'status'])): ?>
                    <a href="<?php echo e(route('superadmin.reports.programs')); ?>" class="py-2.5 px-4 bg-red-50 text-red-600 rounded-xl text-sm font-bold transition-colors">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-[#F4F7FE]/50">
            <div>
                <h3 class="font-bold text-slate-700 uppercase tracking-wide text-sm">Daftar Proker & Statistik Progress</h3>
                <p class="text-xs font-medium text-slate-500 mt-0.5">Total Ditemukan: <?php echo e($programs->count()); ?> program.</p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('superadmin.reports.programs', array_merge(request()->all(), ['export' => 'print']))); ?>" target="_blank" class="px-5 py-2 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Rekap Proker
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Nama Program Kerja</th>
                        <th class="px-6 py-4">Divisi Pelaksana</th>
                        <th class="px-6 py-4">Target Pelaksanaan</th>
                        <th class="px-6 py-4">Fisik Progress</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/40">
                        <td class="px-6 py-4">
                            <!-- Sesuaikan 'name' dengan nama kolom judul proker Anda (misal: 'nama_proker' atau 'title') -->
                            <div class="font-bold text-slate-800 text-sm"><?php echo e($prog->name); ?></div>
                            <div class="text-xs text-slate-400 mt-0.5">Periode: <?php echo e($prog->period->name ?? '-'); ?></div>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-700">
                            <?php echo e($prog->division->name ?? 'Umum / Pengurus Inti'); ?>

                        </td>
                        <td class="px-6 py-4 font-medium text-slate-500">
                            <!-- Sesuaikan 'target_date' dengan nama kolom tanggal Anda -->
                            <?php echo e($prog->target_date ? \Carbon\Carbon::parse($prog->target_date)->format('d M Y') : '-'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-24 bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <!-- Sesuaikan 'progress_percent' jika nama kolom progress Anda berbeda (misal: 'progress') -->
                                    <div class="bg-indigo-500 h-full rounded-full" style="width: <?php echo e($prog->progress_percent ?? 0); ?>%"></div>
                                </div>
                                <span class="text-xs font-extrabold text-slate-700"><?php echo e($prog->progress_percent ?? 0); ?>%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if($prog->status === 'Selesai'): ?>
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-black px-2.5 py-1 rounded-md border border-emerald-100">Selesai</span>
                            <?php elseif($prog->status === 'Berjalan'): ?>
                                <span class="bg-blue-50 text-blue-600 text-xs font-black px-2.5 py-1 rounded-md border border-blue-100">Berjalan</span>
                            <?php else: ?>
                                <span class="bg-red-50 text-red-600 text-xs font-black px-2.5 py-1 rounded-md border border-red-100">Terlambat</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada rekam program kerja yang sesuai dengan filter ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/reports/programs.blade.php ENDPATH**/ ?>