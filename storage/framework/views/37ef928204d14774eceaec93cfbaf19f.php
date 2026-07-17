
<?php $__env->startSection('title', isset($proker) ? 'Edit Program Kerja' : 'Tambah Program Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo e(route('superadmin.prokers.index')); ?>" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">
                <?php echo e(isset($proker) ? 'Edit Program Kerja' : 'Buat Program Kerja'); ?>

            </h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Rencanakan kegiatan divisi dengan detail.</p>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl shadow-sm">
            <ul class="list-disc list-inside text-sm font-medium">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(isset($proker) ? route('superadmin.prokers.update', $proker->id) : route('superadmin.prokers.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($proker)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                <div class="w-8 h-8 bg-indigo-50 text-[#5442F5] rounded-lg flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <h3 class="font-bold text-slate-800">Informasi Dasar</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kode Program <span class="text-red-500">*</span></label>
                    <input type="text" name="program_code" value="<?php echo e(old('program_code', $proker->program_code ?? '')); ?>" required placeholder="Contoh: PK-KOM-001" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Program <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="<?php echo e(old('name', $proker->name ?? '')); ?>" required placeholder="Contoh: Seminar Nasional AI" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Divisi <span class="text-red-500">*</span></label>
                    <select name="division_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <option value="">Pilih Divisi...</option>
                        <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $div): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($div->id); ?>" <?php echo e(old('division_id', $proker->division_id ?? '') == $div->id ? 'selected' : ''); ?>><?php echo e($div->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Periode Kepengurusan <span class="text-red-500">*</span></label>
                    <select name="period_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $per): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($per->id); ?>" <?php echo e(old('period_id', $proker->period_id ?? '') == $per->id ? 'selected' : ''); ?>><?php echo e($per->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                <div class="w-8 h-8 bg-indigo-50 text-[#5442F5] rounded-lg flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <h3 class="font-bold text-slate-800">Pelaksana & Jadwal</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ketua Pelaksana (PIC) <span class="text-red-500">*</span></label>
                    <select name="pic_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <option value="">Pilih Anggota...</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(old('pic_id', $proker->pic_id ?? '') == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Program <span class="text-red-500">*</span></label>
                    <input type="text" name="program_type" value="<?php echo e(old('program_type', $proker->program_type ?? '')); ?>" required placeholder="Contoh: Seminar, Lomba, Pelatihan" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="<?php echo e(old('start_date', $proker->start_date ?? '')); ?>" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deadline / Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="<?php echo e(old('end_date', $proker->end_date ?? '')); ?>" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Pelaksanaan</label>
                    <input type="text" name="location" value="<?php echo e(old('location', $proker->location ?? '')); ?>" placeholder="Contoh: Auditorium Universitas / Zoom Meeting" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                <div class="w-8 h-8 bg-indigo-50 text-[#5442F5] rounded-lg flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                <h3 class="font-bold text-slate-800">Detail & Anggaran</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Estimasi Peserta</label>
                    <input type="number" name="estimated_participants" value="<?php echo e(old('estimated_participants', $proker->estimated_participants ?? 0)); ?>" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rencana Anggaran (Rp)</label>
                    <input type="number" name="budget_planned" value="<?php echo e(old('budget_planned', $proker->budget_planned ?? 0)); ?>" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Prioritas <span class="text-red-500">*</span></label>
                    <select name="priority" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <option value="Rendah" <?php echo e(old('priority', $proker->priority ?? '') == 'Rendah' ? 'selected' : ''); ?>>Rendah</option>
                        <option value="Sedang" <?php echo e(old('priority', $proker->priority ?? 'Sedang') == 'Sedang' ? 'selected' : ''); ?>>Sedang</option>
                        <option value="Tinggi" <?php echo e(old('priority', $proker->priority ?? '') == 'Tinggi' ? 'selected' : ''); ?>>Tinggi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status Program <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                        <option value="Draft" <?php echo e(old('status', $proker->status ?? 'Draft') == 'Draft' ? 'selected' : ''); ?>>Draft (Perencanaan)</option>
                        <option value="Berjalan" <?php echo e(old('status', $proker->status ?? '') == 'Berjalan' ? 'selected' : ''); ?>>Sedang Berjalan</option>
                        <option value="Selesai" <?php echo e(old('status', $proker->status ?? '') == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tujuan Program</label>
                    <textarea name="objective" rows="3" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"><?php echo e(old('objective', $proker->objective ?? '')); ?></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-6">
            <a href="<?php echo e(route('superadmin.prokers.index')); ?>" class="px-8 py-3.5 bg-white text-slate-600 rounded-xl font-bold text-sm shadow-sm hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-xl shadow-indigo-200 transition-colors">
                <?php echo e(isset($proker) ? 'Simpan Perubahan' : 'Buat Program Kerja'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/prokers/form.blade.php ENDPATH**/ ?>