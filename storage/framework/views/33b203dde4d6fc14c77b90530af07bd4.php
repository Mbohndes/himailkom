
<?php $__env->startSection('title', 'Jaringan Alumni HIMA'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Jaringan Alumni HIMA</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Direktori purna tugas, rekam jejak karir, dan koneksi profesional.</p>
        </div>
    </div>

    <form action="<?php echo e(route('superadmin.membership.alumni.index')); ?>" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex gap-3">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama, angkatan, atau tempat kerja..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Cari Alumni</button>
        <?php if(request('search')): ?>
            <a href="<?php echo e(route('superadmin.membership.alumni.index')); ?>" class="px-4 py-2.5 bg-red-50 text-red-600 rounded-xl font-bold flex items-center justify-center">X</a>
        <?php endif; ?>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $alumnis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumni): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all relative overflow-hidden group">
            
            <div class="absolute top-0 left-0 w-full h-16 bg-gradient-to-r from-slate-800 to-slate-700"></div>
            
            <div class="relative z-10 flex items-start gap-4 mt-4">
                <img src="<?php echo e($alumni->photo ? asset('storage/'.$alumni->photo) : 'https://ui-avatars.com/api/?name='.urlencode($alumni->name).'&background=F4F7FE&color=5442F5'); ?>" class="w-20 h-20 rounded-2xl object-cover border-4 border-white shadow-sm bg-white">
                <div class="pt-2">
                    <h3 class="font-extrabold text-slate-800 text-lg leading-tight"><?php echo e($alumni->name); ?></h3>
                    <p class="text-xs font-bold text-[#5442F5] mt-1">Angkatan <?php echo e($alumni->profile->entry_year ?? '-'); ?> • Lulus <?php echo e($alumni->profile->graduation_year ?? '-'); ?></p>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Karir Saat Ini</p>
                        <p class="text-sm font-bold text-slate-700"><?php echo e($alumni->profile->workplace ?? 'Belum ada data karir'); ?></p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-50 text-[#5442F5] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Purna Tugas HIMA</p>
                        <p class="text-sm font-bold text-slate-700"><?php echo e($alumni->position ?? 'Anggota Biasa'); ?></p>
                        <p class="text-[11px] font-medium text-slate-500"><?php echo e($alumni->period->name ?? '-'); ?></p>
                    </div>
                </div>
            </div>

            <?php if($alumni->profile->contribution): ?>
            <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-100">
                <p class="text-xs font-medium text-amber-700 leading-relaxed italic line-clamp-2">"<?php echo e($alumni->profile->contribution); ?>"</p>
            </div>
            <?php endif; ?>

            <div class="mt-5 flex gap-2 pt-5 border-t border-slate-100">
                <a href="<?php echo e(route('superadmin.membership.data.show', $alumni->id)); ?>" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl text-center transition-colors">
                    Lihat Portofolio
                </a>
                
                <?php if($alumni->profile->linkedin_url): ?>
                <a href="<?php echo e($alumni->profile->linkedin_url); ?>" target="_blank" class="flex-1 py-2 bg-[#0A66C2] hover:bg-[#004182] text-white text-xs font-bold rounded-xl text-center transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    LinkedIn
                </a>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-16 text-center bg-white rounded-[30px] border border-slate-100 shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="font-bold text-slate-600 mb-1">Direktori Alumni Kosong</h3>
            <p class="text-sm text-slate-400">Belum ada profil anggota berstatus Nonaktif dengan catatan tahun kelulusan.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="mt-4"><?php echo e($alumnis->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/membership/alumni_index.blade.php ENDPATH**/ ?>