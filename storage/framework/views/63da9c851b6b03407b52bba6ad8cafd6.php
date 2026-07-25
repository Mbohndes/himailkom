<?php
    // Logika cerdas: Cek apakah ini halaman depan (beranda) atau bukan
    $isHome = request()->is('/') ? 'true' : 'false';
?>

<!-- Alpine.js mendeteksi halaman secara otomatis -->
<nav x-data="{
        isHome: <?php echo e($isHome); ?>,
        scrolled: <?php echo e(request()->is('/') ? 'false' : 'true'); ?>,
        mobileMenuOpen: false
     }"
     @scroll.window="if(isHome) { scrolled = (window.pageYOffset > 20) }"
     :class="{'bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm text-slate-800': scrolled, 'bg-transparent text-white border-b border-white/10': !scrolled}"
     class="fixed w-full z-50 top-0 transition-all duration-500">
     
    <div class="max-w-[1400px] mx-auto px-6 lg:px-12 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-3 group">
            <img src="<?php echo e(asset('logo.png')); ?>" onerror="this.outerHTML='<div class=\'w-14 h-14 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg\'>H</div>'" alt="Logo HIMA" class="w-14 h-14 object-contain group-hover:scale-110 transition-transform duration-300">
            <span class="font-extrabold text-xl tracking-tight transition-colors">HIMA <span class="text-[#5442F5]">ILMU KOMPUTER</span></span>
        </a>
        
        <!-- Menu Desktop (Link dipasang url('/') agar bisa diakses dari mana saja) -->
        <div class="hidden lg:flex items-center gap-8 text-sm font-semibold">
            <a href="<?php echo e(url('/#beranda')); ?>" class="hover:text-[#5442F5] transition-colors">Beranda</a>
            <a href="<?php echo e(url('/#tentang')); ?>" class="hover:text-[#5442F5] transition-colors">Tentang Kami</a>
            <a href="<?php echo e(url('/#berita')); ?>" class="hover:text-[#5442F5] transition-colors">Berita</a>
            <a href="<?php echo e(url('/#faq')); ?>" class="hover:text-[#5442F5] transition-colors">FAQ</a>
            <a href="<?php echo e(url('/#kontak')); ?>" class="hover:text-[#5442F5] transition-colors">Kontak</a>
        </div>
        
        <div class="hidden lg:flex items-center gap-3">
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" :class="{'bg-slate-100 text-slate-700 hover:bg-slate-200': scrolled, 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-sm': !scrolled}" class="px-5 py-2.5 text-sm font-bold rounded-full transition-all border border-transparent">Masuk</a>
                <a href="<?php echo e(route('register')); ?>" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-[#5442F5]/30">Daftar</a>
            <?php endif; ?>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('superadmin.dashboard')); ?>" class="px-6 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-[#5442F5]/30 flex items-center gap-2"><span>👋</span> Dashboard</a>
            <?php endif; ?>
        </div>
        
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-full transition-colors" :class="{'bg-slate-100 text-slate-800': scrolled, 'bg-white/10 text-white': !scrolled}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <!-- Menu Mobile -->
    <div x-show="mobileMenuOpen" x-transition class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-slate-100 shadow-xl py-4 px-6 flex flex-col gap-4 text-sm font-bold text-slate-800">
        <a href="<?php echo e(url('/#beranda')); ?>" @click="mobileMenuOpen = false" class="hover:text-[#5442F5]">Beranda</a>
        <a href="<?php echo e(url('/#tentang')); ?>" @click="mobileMenuOpen = false" class="hover:text-[#5442F5]">Tentang Kami</a>
        <a href="<?php echo e(url('/#berita')); ?>" @click="mobileMenuOpen = false" class="hover:text-[#5442F5]">Berita</a>
        <hr class="border-slate-100">
        <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="text-center px-6 py-3 bg-slate-100 rounded-full">Masuk</a>
            <a href="<?php echo e(route('register')); ?>" class="text-center px-6 py-3 bg-[#5442F5] text-white rounded-full">Daftar</a>
        <?php endif; ?>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('superadmin.dashboard')); ?>" class="text-center px-6 py-3 bg-[#5442F5] text-white rounded-full">Ke Dashboard</a>
        <?php endif; ?>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>