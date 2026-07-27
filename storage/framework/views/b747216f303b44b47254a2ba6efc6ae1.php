<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="text-center pb-4">
        <!-- Icon Timer Amber -->
        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-4 border-amber-50">
            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Pendaftaran Berhasil!</h2>
        
        <!-- Pesan Sukses dari Session (Opsional) -->
        <?php if(session('status')): ?>
            <div class="text-sm font-bold text-emerald-600 bg-emerald-50 p-2.5 rounded-lg border border-emerald-100 mb-4 mx-auto max-w-sm shadow-sm">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <p class="text-sm font-medium text-slate-500 mb-6 leading-relaxed">
            Data pendaftaran Anda telah aman tersimpan di ruang karantina sistem. <br><br>
            Saat ini status Anda adalah <span class="bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded text-xs uppercase tracking-wider">Menunggu Verifikasi</span>. Akun resmi Anda akan aktif setelah divalidasi oleh Admin HIMA.
        </p>

        <!-- Kotak Biru Informasi -->
        <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-left text-xs text-blue-700 font-medium mb-8">
            <strong class="block mb-1 text-blue-800">Langkah Selanjutnya:</strong>
            1. Admin akan memverifikasi kesesuaian NIM dan kelengkapan data Anda.<br>
            2. Admin akan menentukan hak akses dan penempatan divisi Anda.<br>
            3. Jika disetujui, Anda dapat login menggunakan password berupa <strong>NIM</strong> Anda.
        </div>

        <!-- Tombol Kembali ke Login (Bukan Logout lagi) -->
        <a href="<?php echo e(route('login')); ?>" class="block w-full py-3 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-colors shadow-sm">
            Kembali ke Halaman Login
        </a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/auth/pending.blade.php ENDPATH**/ ?>