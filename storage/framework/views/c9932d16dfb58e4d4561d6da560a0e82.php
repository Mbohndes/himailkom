
<?php $__env->startSection('title', 'Master Data - Periode'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10" x-data="{ modalOpen: false, isEdit: false, formData: {}, actionUrl: '' }">
    
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Periode Kepengurusan</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelola masa jabatan organisasi HIMA dari masa ke masa.</p>
        </div>
        <button @click="modalOpen = true; isEdit = false; formData = {status: 'Persiapan'}; actionUrl = '<?php echo e(route('superadmin.masterdata.periods.store')); ?>'" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md transition-all flex items-center gap-2">
            + Tambah Periode
        </button>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-bold"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F4F7FE]/60 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                    <th class="px-6 py-4">Nama & Tahun</th>
                    <th class="px-6 py-4">Tanggal Menjabat</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-extrabold text-slate-800 text-base"><?php echo e($p->name); ?></div>
                        <div class="text-xs text-[#5442F5] font-bold mt-0.5"><?php echo e($p->start_year); ?> - <?php echo e($p->end_year); ?></div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-500">
                        <?php echo e($p->start_date ? $p->start_date->format('d M Y') : 'Belum disetel'); ?> <br> 
                        <span class="text-xs text-slate-400">s/d</span> <br>
                        <?php echo e($p->end_date ? $p->end_date->format('d M Y') : 'Belum disetel'); ?>

                    </td>
                    <td class="px-6 py-4">
                        <?php if($p->status === 'Aktif'): ?>
                            <span class="bg-emerald-100 text-emerald-700 text-xs font-black px-3 py-1.5 rounded-lg flex w-max items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif Menjabat</span>
                        <?php elseif($p->status === 'Persiapan'): ?>
                            <span class="bg-amber-50 text-amber-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-100">Persiapan</span>
                        <?php else: ?>
                            <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1.5 rounded-lg">Arsip (Purna)</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Tombol Detail -->
                            <a href="<?php echo e(route('superadmin.masterdata.periods.show', $p->id)); ?>" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors" title="Lihat Detail Visi Misi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            
                            <!-- Tombol Edit Modal -->
                            <button @click="modalOpen = true; isEdit = true; formData = {name: '<?php echo e(addslashes($p->name)); ?>', start_year: '<?php echo e($p->start_year); ?>', end_year: '<?php echo e($p->end_year); ?>', start_date: '<?php echo e($p->start_date ? $p->start_date->format('Y-m-d') : ''); ?>', end_date: '<?php echo e($p->end_date ? $p->end_date->format('Y-m-d') : ''); ?>', status: '<?php echo e($p->status); ?>', theme: '<?php echo e(addslashes($p->theme)); ?>', vision: '<?php echo e(addslashes($p->vision)); ?>', mission: '<?php echo e(addslashes($p->mission)); ?>'}; actionUrl = '<?php echo e(route('superadmin.masterdata.periods.update', $p->id)); ?>'" class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>

                            <!-- Tombol Aksi Status -->
                            <?php if($p->status !== 'Aktif'): ?>
                                <form action="<?php echo e(route('superadmin.masterdata.periods.activate', $p->id)); ?>" method="POST" onsubmit="return confirm('Peringatan: Mengaktifkan periode ini otomatis akan mengarsipkan periode yang sedang aktif saat ini. Lanjutkan?');">
                                    <?php echo csrf_field(); ?> <button class="p-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg font-bold text-[10px] uppercase" title="Aktifkan Periode Ini">Aktifkan</button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('superadmin.masterdata.periods.archive', $p->id)); ?>" method="POST" onsubmit="return confirm('Arsipkan periode ini?');">
                                    <?php echo csrf_field(); ?> <button class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg font-bold text-[10px] uppercase" title="Arsipkan">Arsipkan</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada data periode.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100"><?php echo e($periods->links()); ?></div>
    </div>

    <!-- MODAL FORM TAMBAH/EDIT -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-[30px] p-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto" @click.away="modalOpen = false">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-extrabold text-slate-800 text-xl" x-text="isEdit ? 'Edit Periode' : 'Tambah Periode Baru'"></h3>
                <button @click="modalOpen = false" class="text-slate-400 font-bold">&times;</button>
            </div>

            <form :action="actionUrl" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Periode <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="formData.name" required placeholder="Kabinet Nawasena 2026/2027" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 font-bold focus:ring-[#5442F5]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tahun Mulai <span class="text-red-500">*</span></label>
                        <input type="number" name="start_year" x-model="formData.start_year" required placeholder="2026" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tahun Berakhir <span class="text-red-500">*</span></label>
                        <input type="number" name="end_year" x-model="formData.end_year" required placeholder="2027" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Mulai (Opsional)</label>
                        <input type="date" name="start_date" x-model="formData.start_date" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Akhir (Opsional)</label>
                        <input type="date" name="end_date" x-model="formData.end_date" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                    </div>
                </div>

                <div x-show="!isEdit">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status Awal</label>
                    <select name="status" x-model="formData.status" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                        <option value="Persiapan">Persiapan (Draft)</option>
                        <option value="Aktif">Aktif Menjabat</option>
                        <option value="Arsip">Arsip</option>
                    </select>
                </div>

                <div class="border-t border-slate-100 pt-4 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tema Kepengurusan / Tagline</label>
                        <input type="text" name="theme" x-model="formData.theme" placeholder="Sinergi Berinovasi untuk Negeri" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Visi</label>
                        <textarea name="vision" x-model="formData.vision" rows="2" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Misi (Pisahkan dengan Enter)</label>
                        <textarea name="mission" x-model="formData.mission" rows="4" class="w-full bg-[#F4F7FE] border-none rounded-xl px-4 py-3 focus:ring-[#5442F5]"></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-[#5442F5] hover:bg-[#4331e5] text-white font-extrabold rounded-xl shadow-lg mt-4">Simpan Data Periode</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/masterdata/periods_index.blade.php ENDPATH**/ ?>