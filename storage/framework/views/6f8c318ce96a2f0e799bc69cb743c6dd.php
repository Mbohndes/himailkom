
<?php $__env->startSection('title', isset($agenda) ? 'Edit Agenda Rapat' : 'Tambah Agenda Rapat'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[800px] mx-auto w-full flex flex-col gap-6 pb-10 px-4">
    
    <div>
        <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">
            <?php echo e(isset($agenda) ? 'Edit Agenda Rapat' : 'Tambah Agenda Rapat'); ?>

        </h1>
        <p class="text-sm font-medium text-slate-400 mt-1">
            <?php echo e(isset($agenda) ? 'Perbarui detail data pelaksanaan kegiatan or rapat HIMA.' : 'Buat jadwal agenda kegiatan atau rapat koordinasi pengurus baru.'); ?>

        </p>
    </div>

    <div class="bg-white rounded-[30px] p-6 sm:p-8 shadow-sm border border-slate-100">
        
        <form id="formAgenda" action="<?php echo e(isset($agenda) ? route('superadmin.agendas.update', $agenda->id) : route('superadmin.agendas.store')); ?>" method="POST" class="flex flex-col gap-5">
            <?php echo csrf_field(); ?>
            <?php if(isset($agenda)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul / Nama Agenda</label>
                <input type="text" name="title" id="title" value="<?php echo e(old('title', $agenda->title ?? '')); ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contoh: Rapat Pleno Tengah Tahun">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan</label>
                    <select name="category" id="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                        <option value="" <?php echo e(!old('category', $agenda->category ?? '') ? 'selected' : ''); ?>>-- Pilih Kategori --</option>
                        <option value="Rapat" <?php echo e(old('category', $agenda->category ?? '') == 'Rapat' ? 'selected' : ''); ?>>Rapat</option>
                        <option value="Musyawarah" <?php echo e(old('category', $agenda->category ?? '') == 'Musyawarah' ? 'selected' : ''); ?>>Musyawarah</option>
                        <option value="Evaluasi" <?php echo e(old('category', $agenda->category ?? '') == 'Evaluasi' ? 'selected' : ''); ?>>Evaluasi</option>
                        <option value="Lainnya" <?php echo e(old('category', $agenda->category ?? '') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                    </select>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="period_id" class="block text-sm font-bold text-slate-700 mb-2">Periode HIMA</label>
                    <select name="period_id" id="period_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['period_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                        <option value="" <?php echo e(!old('period_id', $agenda->period_id ?? '') ? 'selected' : ''); ?>>-- Pilih Periode --</option>
                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($period->id); ?>" <?php echo e(old('period_id', $agenda->period_id ?? '') == $period->id ? 'selected' : ''); ?>>
                                <?php echo e($period->name ?? $period->year); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['period_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="date_time" class="block text-sm font-bold text-slate-700 mb-2">Waktu & Tanggal Mulai</label>
                    <input type="datetime-local" name="date_time" id="date_time" value="<?php echo e(old('date_time', isset($agenda->date_time) ? \Carbon\Carbon::parse($agenda->date_time)->format('Y-m-d\TH:i') : '')); ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                    <?php $__errorArgs = ['date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="pic_id" class="block text-sm font-bold text-slate-700 mb-2">Penanggung Jawab (PIC)</label>
                    <select name="pic_id" id="pic_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['pic_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                        <option value="" <?php echo e(!old('pic_id', $agenda->pic_id ?? '') ? 'selected' : ''); ?>>-- Pilih Anggota --</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(old('pic_id', $agenda->pic_id ?? '') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['pic_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-bold text-slate-700 mb-2">Tempat / Lokasi</label>
                <input type="text" name="location" id="location" value="<?php echo e(old('location', $agenda->location ?? '')); ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contoh: Gedung Laboratorium Terpadu R.302 atau Link Zoom">
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Undang Peserta (Otomatis Masuk Absensi)</label>
                <div class="h-48 overflow-y-auto px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer pb-2 border-b border-slate-200 mb-2">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 text-[#5442F5] bg-white border-slate-300 rounded focus:ring-[#5442F5]">
                        <span class="text-sm font-bold text-slate-800">Pilih Semua Anggota</span>
                    </label>
                    
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-3 cursor-pointer hover:bg-slate-100 p-1 rounded-lg transition-colors">
                            <input type="checkbox" name="participants[]" value="<?php echo e($user->id); ?>" class="peserta-checkbox w-4 h-4 text-[#5442F5] bg-white border-slate-300 rounded focus:ring-[#5442F5]">
                            <span class="text-sm font-medium text-slate-700"><?php echo e($user->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['participants'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1 font-medium bg-red-50 p-2 rounded"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex items-center justify-end gap-3 mt-4 pt-6 border-t border-slate-100">
                <a href="<?php echo e(route('superadmin.agendas.index')); ?>" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold text-sm transition-colors">
                    Batal
                </a>
                
                <button type="button" onclick="document.getElementById('formAgenda').submit()" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md shadow-indigo-100 transition-colors">
                    <?php echo e(isset($agenda) ? 'Simpan Perubahan' : 'Tambah Agenda'); ?>

                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.peserta-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/agendas/form.blade.php ENDPATH**/ ?>