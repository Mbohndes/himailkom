
<?php $__env->startSection('title', 'Aktivitas Log Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Audit Trail & Aktivitas Log</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Pantau seluruh jejak rekam perubahan data dan aktivitas pengguna di dalam sistem HIMA.</p>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <form action="<?php echo e(route('superadmin.activity_logs.index')); ?>" method="GET" class="flex flex-col sm:flex-row gap-4">
            
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama pengguna atau rincian aktivitas..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
            
            <select name="module" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
                <option value="">Semua Modul</option>
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($mod); ?>" <?php echo e(request('module') == $mod ? 'selected' : ''); ?>><?php echo e($mod); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="action" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-40">
                <option value="">Semua Aksi</option>
                <option value="CREATE" <?php echo e(request('action') == 'CREATE' ? 'selected' : ''); ?>>CREATE (Tambah)</option>
                <option value="UPDATE" <?php echo e(request('action') == 'UPDATE' ? 'selected' : ''); ?>>UPDATE (Ubah)</option>
                <option value="DELETE" <?php echo e(request('action') == 'DELETE' ? 'selected' : ''); ?>>DELETE (Hapus)</option>
                <option value="LOGIN" <?php echo e(request('action') == 'LOGIN' ? 'selected' : ''); ?>>LOGIN (Akses)</option>
            </select>
            
            <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Filter Data</button>
            
            <?php if(request()->anyFilled(['search', 'module', 'action'])): ?>
                <a href="<?php echo e(route('superadmin.activity_logs.index')); ?>" class="px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl text-sm font-bold transition-colors flex items-center justify-center">X</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE]/50 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Waktu Kejadian</th>
                        <th class="px-6 py-4">Pelaku (Pengguna)</th>
                        <th class="px-6 py-4">Modul & Aksi</th>
                        <th class="px-6 py-4">Rincian Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-slate-700"><?php echo e($log->created_at->format('d M Y')); ?></div>
                            <div class="text-[11px] text-slate-400 mt-0.5"><?php echo e($log->created_at->format('H:i:s')); ?> WIB</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo e($log->user && $log->user->photo ? asset('storage/'.$log->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($log->user->name ?? 'Sistem').'&background=F4F7FE&color=5442F5'); ?>" class="w-8 h-8 rounded-full border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm"><?php echo e($log->user->name ?? 'Sistem / Guest'); ?></div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5">IP: <?php echo e($log->ip_address ?? 'Unknown'); ?></div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 text-xs mb-1 uppercase tracking-wide"><?php echo e($log->module); ?></div>
                            <?php if($log->action === 'CREATE'): ?>
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-extrabold px-2 py-0.5 rounded">CREATE</span>
                            <?php elseif($log->action === 'UPDATE'): ?>
                                <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-extrabold px-2 py-0.5 rounded">UPDATE</span>
                            <?php elseif($log->action === 'DELETE'): ?>
                                <span class="bg-red-50 text-red-600 border border-red-100 text-[10px] font-extrabold px-2 py-0.5 rounded">DELETE</span>
                            <?php else: ?>
                                <span class="bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-extrabold px-2 py-0.5 rounded"><?php echo e($log->action); ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-600 text-sm max-w-md line-clamp-2">
                            <?php echo e($log->description); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="block font-bold text-slate-500 mb-1">Log Bersih</span>
                            Belum ada aktivitas yang direkam oleh sistem.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/30"><?php echo e($logs->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/activity_logs/index.blade.php ENDPATH**/ ?>