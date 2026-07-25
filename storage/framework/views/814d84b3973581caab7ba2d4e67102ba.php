

<?php $__env->startSection('title', $news->title ?? 'Detail Berita'); ?>

<?php $__env->startSection('content'); ?>

<!-- CSS Paksa (Force Style) untuk menjamin ukuran 75% Kiri dan 25% Kanan di Desktop -->
<style>
    @media (min-width: 1024px) {
        .layout-kiri { width: 73% !important; flex: none !important; }
        .layout-kanan { width: 24% !important; flex: none !important; }
    }
</style>

<!-- Padding top 140px menjamin jarak aman dari Navbar -->
<section style="padding-top: 140px;" class="pb-20 px-4 sm:px-6 lg:px-12 max-w-[1400px] mx-auto min-h-screen w-full">
    
    <!-- Menggunakan Flexbox agar tata letaknya solid dan kebal error -->
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-[3%] items-start w-full">
        
        <!-- ======================================================== -->
        <!-- KIRI (75%): BERITA UTAMA                                 -->
        <!-- ======================================================== -->
        <article class="layout-kiri w-full bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-sm">
            
            <a href="<?php echo e(url('/#berita')); ?>" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#5442F5] transition-colors mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar Berita
            </a>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 leading-[1.25] tracking-tight mb-6">
                <?php echo e($news->title); ?>

            </h1>
            
            <div class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-500 mb-8 pb-8 border-b border-slate-100">
                <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full text-slate-700 border border-slate-200">
                    <span>✍️</span> <?php echo e(optional($news->author)->name ?? optional($news->penulis)->name ?? 'Tim Kominfo'); ?>

                </div>
                <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full text-slate-700 border border-slate-200">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <?php echo e(\Carbon\Carbon::parse($news->created_at ?? $news->date)->translatedFormat('l, d F Y')); ?>

                </div>
            </div>

            <?php
                $gambarUtama = $news->thumbnail ?? $news->image ?? $news->gambar ?? '';
                $pathUtama = str_starts_with($gambarUtama, 'storage') ? asset($gambarUtama) : asset('storage/' . $gambarUtama);
            ?>

            <?php if(!empty($gambarUtama)): ?>
                <div class="w-full rounded-2xl overflow-hidden mb-10 border border-slate-100 shadow-sm bg-slate-100">
                    <img src="<?php echo e($pathUtama); ?>" alt="<?php echo e($news->title); ?>" class="w-full aspect-video object-cover">
                </div>
            <?php endif; ?>

            <div class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-a:text-[#5442F5] prose-img:rounded-xl">
                <?php echo $news->content ?? $news->body ?? $news->deskripsi; ?>

            </div>

        </article>

        <!-- ======================================================== -->
        <!-- KANAN (25%): PREVIEW BERITA LAIN                         -->
        <!-- ======================================================== -->
        <aside class="layout-kanan w-full">
            <div class="sticky top-32">
                
                <h3 class="text-base font-extrabold text-slate-800 mb-5 flex items-center gap-2 border-b border-slate-200 pb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#5442F5]"></span> Berita Lainnya
                </h3>
                
                <div class="flex flex-col gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $beritaLainnya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lainnya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $gambarLain = $lainnya->thumbnail ?? $lainnya->image ?? $lainnya->gambar ?? '';
                            $pathLain = str_starts_with($gambarLain, 'storage') ? asset($gambarLain) : asset('storage/' . $gambarLain);
                        ?>
                        
                        <!-- CARD PREVIEW KECIL: Kotak putih solid dengan shadow halus -->
                        <a href="<?php echo e(url('/berita/' . ($lainnya->slug ?? $lainnya->id))); ?>" class="group flex items-start gap-3 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:border-[#5442F5]/30">
                            
                            <!-- Thumbnail Preview -->
                            <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-lg bg-slate-50 border border-slate-100 overflow-hidden relative">
                                <?php if(!empty($gambarLain)): ?>
                                    <img src="<?php echo e($pathLain); ?>" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xl opacity-40">📰</div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Teks & Tanggal Kanan -->
                            <div class="flex flex-col pt-0.5">
                                <span class="text-[9px] font-bold text-[#5442F5] uppercase tracking-wider mb-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <?php echo e(\Carbon\Carbon::parse($lainnya->created_at ?? $lainnya->date)->translatedFormat('d M Y')); ?>

                                </span>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-700 leading-snug line-clamp-2 group-hover:text-[#5442F5] transition-colors">
                                    <?php echo e($lainnya->title); ?>

                                </h4>
                            </div>
                            
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-6 bg-white rounded-2xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400">Belum ada berita lain.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </aside>

    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/berita/show.blade.php ENDPATH**/ ?>