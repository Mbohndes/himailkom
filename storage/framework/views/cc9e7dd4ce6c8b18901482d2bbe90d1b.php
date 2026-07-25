<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'HIMA ILKOM UMKU'); ?></title>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen">

    <!-- Memanggil Navbar 1 Pintu -->
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Konten Utama (Diberi pt-32 agar konten didorong ke bawah) -->
    <main class="flex-grow pt-28 sm:pt-32 pb-20">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Memanggil Footer 1 Pintu -->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/layouts/public.blade.php ENDPATH**/ ?>