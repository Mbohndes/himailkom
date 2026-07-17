
<?php $__env->startSection('title', 'Data Pembayaran Iuran'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Data Pembayaran Iuran</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Verifikasi pengajuan bukti bayar, catat setoran manual, dan pantau histori kas masuk.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('superadmin.finance.payments')); ?>" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-3 mb-2">
        
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama mahasiswa atau NIM..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
        
        <select name="due_id" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
            <option value="">Semua Tagihan</option>
            <?php $__currentLoopData = $dues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $due): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($due->id); ?>" <?php echo e(request('due_id') == $due->id ? 'selected' : ''); ?>>
                    <?php echo e($due->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="status" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-40">
            <option value="">Semua Status</option>
            <option value="Lunas" <?php echo e(request('status') == 'Lunas' ? 'selected' : ''); ?>>Lunas</option>
            <option value="Belum Lunas" <?php echo e(request('status') == 'Belum Lunas' ? 'selected' : ''); ?>>Belum Lunas</option>
        </select>

        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Filter</button>
        
        <?php if(request()->anyFilled(['search', 'due_id', 'status'])): ?>
            <a href="<?php echo e(route('superadmin.finance.payments')); ?>" class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-bold transition-colors flex items-center justify-center" title="Reset Filter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        <?php endif; ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800"><?php echo e($p->user->name); ?></div>
                            <div class="text-xs text-slate-400 font-medium mt-0.5">NIM: <?php echo e($p->user->nim ?? '-'); ?></div>
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            <?php echo e($payment->due->name ?? 'Tagihan Terhapus'); ?>


                            
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-800">
                            Rp <?php echo e(number_format($payment->due?->amount ?? 0, 0, ',', '.')); ?>

                            <div class="text-[11px] text-slate-400 font-medium mt-0.5">Dari: Rp <?php echo e(number_format($p->due->amount, 0, ',', '.')); ?></div>
                        </td>

                        <td class="px-6 py-4 font-medium">
                            <?php if($p->status === 'Lunas'): ?>
                                <div class="text-slate-700 font-bold"><?php echo e($p->payment_method ?? 'Manual'); ?></div>
                                <div class="text-[11px] text-slate-400 mt-0.5"><?php echo e($p->paid_at ? $p->paid_at->format('d M Y, H:i') : '-'); ?></div>
                            <?php else: ?>
                                <span class="text-slate-300 italic">Belum ada setor</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4">
                            <?php if($p->status === 'Lunas'): ?>
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-extrabold px-3 py-1 rounded-md border border-emerald-100 block w-max">Lunas</span>
                            <?php else: ?>
                                <span class="bg-amber-50 text-amber-600 text-xs font-extrabold px-3 py-1 rounded-md border border-amber-100 block w-max">Belum Lunas</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <?php if($p->status !== 'Lunas'): ?>
                                
                                <!-- Tombol Verifikasi HANYA terlihat oleh Super Admin dan BPH -->
                                <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|BPH')): ?>
                                    <form action="<?php echo e(route('superadmin.finance.payments.verify', $p->id)); ?>" method="POST" onsubmit="return confirm('Sahkan status pembayaran tunai untuk <?php echo e($p->user->name); ?>?');">
                                        <?php echo csrf_field(); ?>
                                        <!-- Penanda Aksi Normal -->
                                        <input type="hidden" name="action" value="verify">
                                        <button type="submit" class="px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
                                            Sahkan Lunas
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- Anggota dan Kadiv hanya melihat tombol Upload Bukti -->
                                    <button class="px-4 py-1.5 bg-[#5442F5] hover:bg-[#4331e5] text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
                                        Kirim Bukti Bayar
                                    </button>
                                <?php endif; ?>

                            <?php else: ?>
                                <!-- JIKA STATUS SUDAH LUNAS -->
                                <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|BPH')): ?>
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-emerald-500 font-bold text-xs flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terverifikasi
                                        </span>
                                        
                                        <!-- Tombol Pembatalan (Hanya BPH/Super Admin yang bisa lihat) -->
                                        <form action="<?php echo e(route('superadmin.finance.payments.verify', $p->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan status lunas untuk <?php echo e($p->user->name); ?>? Data setoran akan dikembalikan menjadi 0.');">
                                            <?php echo csrf_field(); ?>
                                            <!-- Penanda Aksi Batal -->
                                            <input type="hidden" name="action" value="unverify">
                                            <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors" title="Batalkan Lunas (Revert)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <!-- Jika yang melihat Anggota biasa, cuma ada label tanpa tombol silang -->
                                    <div class="flex items-center justify-end text-emerald-500 font-bold text-xs gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terverifikasi
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">
                            Belum ada rekam transaksi iuran yang tercatat di database.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
            <?php echo e($payments->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/dues/payments.blade.php ENDPATH**/ ?>