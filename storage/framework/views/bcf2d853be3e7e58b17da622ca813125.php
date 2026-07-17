
<?php $__env->startSection('title', 'Database Anggota HIMA'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Database Organisasi</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Pusat rekam jejak, portofolio, dan buku induk seluruh anggota serta pengurus HIMA.</p>
    </div>

    <form action="<?php echo e(route('superadmin.membership.data.index')); ?>" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex gap-3">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau NIM..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
        <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm">Cari Entri</button>
    </form>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F4F7FE]/60 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                    <th class="px-6 py-4">Informasi Dasar</th>
                    <th class="px-6 py-4">Riwayat Divisi Terakhir</th>
                    <th class="px-6 py-4">Status Keanggotaan</th>
                    <th class="px-6 py-4 text-right">Rekam Jejak</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800"><?php echo e($m->name); ?></div>
                        <div class="text-xs text-slate-500 mt-0.5">NIM: <?php echo e($m->nim ?? '-'); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700"><?php echo e($m->division->name ?? 'Belum ada divisi'); ?></div>
                        <div class="text-xs text-slate-400"><?php echo e($m->position ?? 'Anggota'); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($m->status === 'Aktif'): ?>
                            <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1 rounded-md">Aktif</span>
                        <?php else: ?>
                            <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-md">Alumni / Inaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="<?php echo e(route('superadmin.membership.data.show', $m->id)); ?>" class="px-4 py-2 bg-[#F4F7FE] hover:bg-[#5442F5] text-[#5442F5] hover:text-white font-bold text-xs rounded-xl transition-colors inline-flex items-center gap-2">
                            Lihat Buku Induk &rarr;
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100"><?php echo e($members->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/membership/data_index.blade.php ENDPATH**/ ?>