<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIM HIMA Ilmu Komputer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white antialiased selection:bg-[#5442F5] selection:text-white">

    <div class="flex min-h-screen">
        
        <!-- KOLOM KIRI (Visual & Branding) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden items-center justify-center">
            <!-- Background Image -->
            <div class="absolute inset-0 w-full h-full">
                <img src="ilkom.jpeg" alt="HIMA Ilkom" class="w-full h-full object-cover opacity-50">
            </div>
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#5442F5]/90 to-slate-900/90 backdrop-blur-[2px]"></div>
            
            <!-- Konten Visual -->
            <div class="relative z-10 p-12 max-w-lg text-white">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl mb-8 border border-white/20 shadow-lg">
                    🎓
                </div>
                <h1 class="text-4xl font-extrabold mb-4 leading-tight tracking-tight">Selamat Datang di <br>Sistem Informasi <span class="text-[#818CF8]">HIMA</span></h1>
                <p class="text-indigo-100 text-sm font-medium leading-relaxed">
                    Portal terintegrasi untuk manajemen organisasi, presensi kegiatan, program kerja, dan transparansi administrasi Himpunan Mahasiswa Ilmu Komputer.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN (Form Login) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-20 bg-white">
            <div class="w-full max-w-md">
                
                <!-- Logo & Judul Mobile -->
                <div class="text-center lg:text-left mb-10">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group mb-8">
                        <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<div class=\'w-10 h-10 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-md\'>H</div>'" alt="Logo HIMA" class="w-10 h-10 object-contain">
                        <span class="font-extrabold text-xl tracking-tight text-slate-800">HIMA <span class="text-[#5442F5]">Ilkom</span></span>
                    </a>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Masuk ke Akun</h2>
                    <p class="text-sm font-medium text-slate-500">Silakan masukkan email dan password Anda.</p>
                </div>

                <!-- Alert Error (Jika ada kegagalan login) -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-bold">
                        Email atau password yang Anda masukkan salah.
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@kampus.ac.id" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#5442F5] hover:underline">Lupa Sandi?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] focus:bg-white transition-all outline-none">
                    </div>

                    <!-- Ingat Saya (Remember Me) -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-[#5442F5] focus:ring-[#5442F5] border-slate-300 cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-[#5442F5]/30 text-sm font-bold text-white bg-[#5442F5] hover:bg-[#4331e5] focus:outline-none transition-all active:scale-[0.98]">
                        Masuk Sekarang
                    </button>
                </form>

                <!-- Link ke Register -->
                <p class="mt-8 text-center text-sm font-medium text-slate-500">
                    Belum punya akun pengurus? 
                    <a href="{{ route('register') }}" class="font-bold text-[#5442F5] hover:underline">Daftar di sini</a>
                </p>
                
            </div>
        </div>

    </div>
</body>
</html>