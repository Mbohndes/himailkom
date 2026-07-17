
<?php $__env->startSection('title', isset($division) ? 'Edit Divisi' : 'Tambah Divisi'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">
            <?php echo e(isset($division) ? 'Edit Divisi' : 'Tambah Divisi Baru'); ?>

        </h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Isi formulir di bawah ini dengan lengkap dan benar.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm font-medium">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">
        <form action="<?php echo e(isset($division) ? route('superadmin.divisions.update', $division->id) : route('superadmin.divisions.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($division)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Divisi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="<?php echo e(old('name', $division->name ?? '')); ?>" required placeholder="Contoh: Komunikasi dan Informasi"
                        class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Singkatan <span class="text-red-500">*</span></label>
                    <input type="text" name="abbreviation" value="<?php echo e(old('abbreviation', $division->abbreviation ?? '')); ?>" required placeholder="Contoh: Kominfo"
                        class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                    <option value="Aktif" <?php echo e(old('status', $division->status ?? '') == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="Nonaktif" <?php echo e(old('status', $division->status ?? '') == 'Nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Divisi</label>
                <textarea name="description" rows="3" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]" placeholder="Tuliskan deskripsi singkat mengenai tugas divisi ini..."><?php echo e(old('description', $division->description ?? '')); ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Visi</label>
                    <textarea name="vision" rows="4" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"><?php echo e(old('vision', $division->vision ?? '')); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Misi</label>
                    <textarea name="mission" rows="4" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"><?php echo e(old('mission', $division->mission ?? '')); ?></textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
                <a href="<?php echo e(route('superadmin.divisions.index')); ?>" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-200 transition-colors">
                    <?php echo e(isset($division) ? 'Simpan Perubahan' : 'Tambahkan Divisi'); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/divisions/form.blade.php ENDPATH**/ ?>