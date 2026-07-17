
<?php $__env->startSection('title', 'Detail & Absensi Agenda'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center justify-between bg-white p-6 rounded-[30px] shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <a href="<?php echo e(route('superadmin.agendas.index')); ?>" class="w-10 h-10 bg-slate-50 hover:bg-slate-100 rounded-full flex items-center justify-center text-slate-500 transition-colors">
                &larr;
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800"><?php echo e($agenda->title); ?></h1>
                <p class="text-sm font-medium text-slate-400 mt-1">
                    📍 <?php echo e($agenda->location); ?> &nbsp;|&nbsp; 🕒 <?php echo e(\Carbon\Carbon::parse($agenda->date_time)->format('d M Y, H:i')); ?>

                </p>
            </div>
        </div>
        <span class="px-4 py-2 rounded-xl text-sm font-bold bg-indigo-50 text-[#5442F5]">PIC: <?php echo e($agenda->pic->name ?? 'Tidak Ada'); ?></span>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 text-center">
            <p class="text-xs font-bold text-emerald-700 uppercase">Hadir</p>
            <h3 class="text-2xl font-black text-emerald-800"><?php echo e($rekap['Hadir']); ?></h3>
        </div>
        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 text-center">
            <p class="text-xs font-bold text-blue-700 uppercase">Izin</p>
            <h3 class="text-2xl font-black text-blue-800"><?php echo e($rekap['Izin']); ?></h3>
        </div>
        <div class="bg-amber-50 p-4 rounded-2xl border border-amber-100 text-center">
            <p class="text-xs font-bold text-amber-700 uppercase">Sakit</p>
            <h3 class="text-2xl font-black text-amber-800"><?php echo e($rekap['Sakit']); ?></h3>
        </div>
        <div class="bg-red-50 p-4 rounded-2xl border border-red-100 text-center">
            <p class="text-xs font-bold text-red-700 uppercase">Alfa</p>
            <h3 class="text-2xl font-black text-red-800"><?php echo e($rekap['Alfa']); ?></h3>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center">
            <p class="text-xs font-bold text-slate-500 uppercase">Belum Absen</p>
            <h3 class="text-2xl font-black text-slate-700"><?php echo e($rekap['Belum Absen']); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-extrabold text-slate-800">Daftar Kehadiran Peserta</h3>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F4F7FE] text-slate-400 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4">Nama Peserta</th>
                    <th class="px-6 py-4">Status Saat Ini</th>
                    <th class="px-6 py-4 text-center">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $agenda->attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-bold text-slate-800"><?php echo e($absen->user->name ?? 'Anonim'); ?></td>
                    <td class="px-6 py-4">
                        <?php
                            $color = match($absen->status) {
                                'Hadir' => 'bg-emerald-100 text-emerald-700',
                                'Izin' => 'bg-blue-100 text-blue-700',
                                'Sakit' => 'bg-amber-100 text-amber-700',
                                'Alfa' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-600',
                            };
                        ?>
                        <span class="px-3 py-1 rounded-lg text-xs font-bold <?php echo e($color); ?>"><?php echo e($absen->status); ?></span>
                    </td>
                    
                    <td class="px-6 py-4 text-right">
                        
                        <?php if (! \Illuminate\Support\Facades\Blade::check('role', 'Anggota')): ?>
                            <form action="<?php echo e(route('superadmin.agendas.updateAttendance', $agenda->id)); ?>" method="POST" class="flex items-center justify-end gap-2">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="user_id" value="<?php echo e($absen->user_id); ?>">
                                <select name="status" class="bg-slate-50 border border-slate-200 text-xs rounded-lg px-2 py-1 focus:ring-[#5442F5]">
                                    <option value="Hadir" <?php echo e($absen->status == 'Hadir' ? 'selected' : ''); ?>>Hadir</option>
                                    <option value="Izin" <?php echo e($absen->status == 'Izin' ? 'selected' : ''); ?>>Izin</option>
                                    <option value="Sakit" <?php echo e($absen->status == 'Sakit' ? 'selected' : ''); ?>>Sakit</option>
                                    <option value="Alfa" <?php echo e($absen->status == 'Alfa' ? 'selected' : ''); ?>>Alfa</option>
                                </select>
                                <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-bold rounded-lg transition-colors">
                                    Simpan
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-xs font-bold text-slate-400 italic">Akses Terbatas</span>
                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400">Belum ada peserta yang diundang ke agenda ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/agendas/show.blade.php ENDPATH**/ ?>