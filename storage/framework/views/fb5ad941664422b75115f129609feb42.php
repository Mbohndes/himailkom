<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengurus - SIM HIMA Ilmu Komputer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white antialiased selection:bg-[#5442F5] selection:text-white">

    <div class="flex min-h-screen">
        
        <!-- KOLOM KIRI (Visual & Branding) - Gambar dibedakan sedikit -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden items-center justify-center order-2">
            <div class="absolute inset-0 w-full h-full">
                <!-- Foto kegiatan / kebersamaan -->
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="HIMA Ilkom" class="w-full h-full object-cover opacity-40">
            </div>
            <!-- Gradient Overlay (Warna lebih kebiruan) -->
            <div class="absolute inset-0 bg-gradient-to-bl from-[#38BDF8]/80 to-[#5442F5]/90 backdrop-blur-[2px]"></div>
            
            <div class="relative z-10 p-12 max-w-lg text-white">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl mb-8 border border-white/20 shadow-lg">
                    🚀
                </div>
                <h1 class="text-4xl font-extrabold mb-4 leading-tight tracking-tight">Mulai Perjalanan Anda Bersama Kami</h1>
                <p class="text-indigo-100 text-sm font-medium leading-relaxed">
                    Bergabunglah menjadi bagian dari struktur kepengurusan. Kembangkan potensi diri, perbanyak relasi, dan ciptakan karya inovatif untuk Ilmu Komputer.
                </p>
                
                <!-- Testimonial / Info Box -->
                <div class="mt-10 p-5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-[24px]">
                    <p class="text-sm font-bold text-white mb-1">Informasi Pendaftaran</p>
                    <p class="text-xs text-indigo-100 leading-relaxed">Setelah mendaftar, akun Anda akan berstatus "Pending". Silakan hubungi BPH (Super Admin) untuk proses verifikasi dan penempatan Role/Divisi.</p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (Form Register) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-20 bg-white order-1">
            <div class="w-full max-w-md">
                
                <!-- Logo & Judul -->
                <div class="text-center lg:text-left mb-8">
                    <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-3 group mb-6">
                        <img src="<?php echo e(asset('logo.png')); ?>" onerror="this.outerHTML='<div class=\'w-10 h-10 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-md\'>H</div>'" alt="Logo HIMA" class="w-10 h-10 object-contain">
                    </a>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Buat Akun Baru</h2>
                    <p class="text-sm font-medium text-slate-500">Lengkapi data diri Anda di bawah ini.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5" novalidate>
                    <?php echo csrf_field(); ?>
                    
                    <!-- Input Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus placeholder="Contoh: Muhammad Ilham" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="nim" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIM (Nomor Induk Mahasiswa)</label>
                        <input id="nim" type="text" name="nim" value="<?php echo e(old('nim')); ?>" required placeholder="Contoh: 2024xxxx" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                        <?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="Gunakan email aktif" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Input Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sandi Baru</label>
                            <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter" 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ulangi Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ketik ulang sandi" 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-[#5442F5]/30 text-sm font-bold text-white bg-[#5442F5] hover:bg-[#4331e5] focus:outline-none transition-all active:scale-[0.98] mt-4">
                        Daftarkan Akun
                    </button>
                </form>

                <!-- Link ke Login -->
                <p class="mt-8 text-center text-sm font-medium text-slate-500">
                    Sudah memiliki akun pengurus? 
                    <a href="<?php echo e(route('login')); ?>" class="font-bold text-[#5442F5] hover:underline">Masuk di sini</a>
                </p>
                
            </div>
        </div>

    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/auth/register.blade.php ENDPATH**/ ?>