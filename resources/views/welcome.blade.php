<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMA Ilmu Komputer | Universitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F8FAFC; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        /* Animasi */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="antialiased selection:bg-[#5442F5] selection:text-white" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">

    <nav :class="{'bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm text-slate-800': scrolled, 'bg-transparent text-white border-b border-white/10': !scrolled}" 
         class="fixed w-full z-50 top-0 transition-all duration-500">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3 group">
                <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<div class=\'w-14 h-14 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg\'>H</div>'" alt="Logo HIMA" class="w-14 h-14 object-contain group-hover:scale-110 transition-transform duration-300">
                <span class="font-extrabold text-xl tracking-tight transition-colors">HIMA <span class="text-[#5442F5]">ILMU KOMPUTER</span></span>
            </a>
            <div class="hidden lg:flex items-center gap-8 text-sm font-semibold">
                <a href="#beranda" class="hover:text-[#5442F5] transition-colors">Beranda</a>
                <a href="#tentang" class="hover:text-[#5442F5] transition-colors">Tentang Kami</a>
                <a href="#berita" class="hover:text-[#5442F5] transition-colors">Berita</a>
                <a href="#faq" class="hover:text-[#5442F5] transition-colors">FAQ</a>
                <a href="#kontak" class="hover:text-[#5442F5] transition-colors">Kontak</a>
            </div>
            <div class="hidden lg:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" :class="{'bg-slate-100 text-slate-700 hover:bg-slate-200': scrolled, 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-sm': !scrolled}" class="px-5 py-2.5 text-sm font-bold rounded-full transition-all border border-transparent">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-[#5442F5]/30">Daftar</a>
                @endguest
                @auth
                    <a href="{{ route('superadmin.dashboard') }}" class="px-6 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-[#5442F5]/30 flex items-center gap-2"><span>👋</span> Dashboard</a>
                @endauth
            </div>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-full transition-colors" :class="{'bg-slate-100 text-slate-800': scrolled, 'bg-white/10 text-white': !scrolled}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-slate-100 shadow-xl py-4 px-6 flex flex-col gap-4 text-sm font-bold text-slate-800">
            <a href="#beranda" @click="mobileMenuOpen = false" class="hover:text-[#5442F5]">Beranda</a>
            <a href="#tentang" @click="mobileMenuOpen = false" class="hover:text-[#5442F5]">Tentang Kami</a>
            <hr class="border-slate-100">
            @guest
                <a href="{{ route('login') }}" class="text-center px-6 py-3 bg-slate-100 rounded-full">Masuk</a>
                <a href="{{ route('register') }}" class="text-center px-6 py-3 bg-[#5442F5] text-white rounded-full">Daftar</a>
            @endguest
            @auth
                <a href="{{ route('superadmin.dashboard') }}" class="text-center px-6 py-3 bg-[#5442F5] text-white rounded-full">Ke Dashboard</a>
            @endauth
        </div>
    </nav>

    <section id="beranda" class="relative w-full h-screen min-h-[700px] flex items-center justify-start overflow-hidden bg-slate-900">
        <div class="absolute inset-0 w-full h-full">
            <img src="hima.png" alt="Kegiatan HIMA" class="w-full h-full object-cover opacity-80">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/70 "></div>

        <div class="relative z-10 w-full max-w-[1400px] mx-auto px-6 lg:px-12 flex">
            <div class="w-full lg:w-[65%] flex flex-col justify-center">
                <div class="animate-fade-in-up inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-indigo-100 text-sm font-semibold rounded-full w-fit mb-6">
                    <span class="text-base">🏛</span> Himpunan Mahasiswa Ilmu Komputer
                </div>
                <h1 class="animate-fade-in-up delay-100 text-4xl sm:text-5xl lg:text-[4.5rem] font-extrabold text-white leading-[1.1] tracking-tight mb-6">
                    Bangun Generasi Informatika yang <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#818CF8] to-[#38BDF8]">Inovatif</span>, Kolaboratif, dan Berdampak
                </h1>
                <p class="animate-fade-in-up delay-200 text-base lg:text-lg text-slate-300 font-medium max-w-2xl leading-relaxed mb-10">
                    Website resmi Himpunan Mahasiswa Ilmu Komputer sebagai pusat informasi, publikasi, serta sistem administrasi organisasi yang mendukung kolaborasi, pengembangan kompetensi, dan transparansi seluruh kegiatan kemahasiswaan.
                </p>
                <div class="animate-fade-in-up delay-300 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto text-center px-8 py-4 bg-[#5442F5] hover:bg-[#4331e5] text-white text-[15px] font-bold rounded-full transition-all shadow-lg">Masuk ke SIM HIMA</a>
                    <a href="#tentang" class="w-full sm:w-auto text-center px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white text-[15px] font-bold rounded-full transition-all">Pelajari Tentang HIMA</a>
                </div>
            </div>
        </div>
        <a href="#tentang" class="animate-fade-in-up delay-400 absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/60 hover:text-white transition-colors cursor-pointer group">
            <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Scroll Ke Bawah</span>
            <div class="w-8 h-8 rounded-full border border-white/30 flex items-center justify-center group-hover:border-white transition-colors animate-bounce">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </a>
    </section>

    <!-- ========================================== -->
    <!-- 3. TENTANG KAMI (Compact & Elegan)         -->
    <!-- ========================================== -->
    <section id="tentang" class="bg-white rounded-t-[40px] lg:rounded-t-[64px] -mt-8 relative z-20 pt-16 pb-16 px-4 sm:px-6 lg:px-12">
        <div class="max-w-[1200px] mx-auto">
            
            <!-- A. PROFIL SINGKAT -->
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mb-20">
                <!-- Gambar (Diperkecil Tinggi & Radiusnya) -->
                <div class="w-full lg:w-5/12 h-[280px] lg:h-[350px] rounded-[32px] overflow-hidden relative shadow-xl shadow-slate-200">
                    <img src="ilkom.jpeg" alt="Kegiatan HIMA" class="w-full h-full object-cover">
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full font-bold text-[#5442F5] text-xs shadow-md">
                        
                    </div>
                </div>
                
                <!-- Teks Deskripsi (Font & Margin Disesuaikan) -->
                <div class="w-full lg:w-7/12">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight mb-4 tracking-tight uppercase">
                        RUANG KOLABORASI <br> <span class="text-slate-400 font-medium">MAHASISWA</span> ILKOM.
                    </h2>
                    <p class="text-sm lg:text-base text-slate-500 font-medium leading-relaxed mb-6">
                        Himpunan Mahasiswa Ilmu Komputer (HIMA Ilkom) adalah wadah bagi mahasiswa untuk mengembangkan potensi akademik, kepemimpinan, dan soft skill. Kami hadir untuk menjembatani aspirasi mahasiswa dengan program studi, serta menciptakan inovasi teknologi.
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-[#5442F5] text-white text-sm font-bold rounded-full transition-all shadow-md">
                        Pelajari Sejarah Kami <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- B. VISI & MISI (Card Diperkecil) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-20">
                <!-- Card Visi -->
                <div class="bg-[#5442F5] rounded-[32px] p-8 lg:p-10 text-white relative overflow-hidden shadow-xl shadow-indigo-500/20 group">
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-xl mb-5">👁️</div>
                    <h3 class="text-2xl font-extrabold mb-3 tracking-tight">Visi HIMA</h3>
                    <p class="text-indigo-100 text-sm font-medium leading-relaxed">
                        Menjadikan Himpunan Mahasiswa Ilmu Komputer sebagai organisasi yang progresif, adaptif terhadap perkembangan teknologi global, dan berlandaskan asas kekeluargaan yang erat.
                    </p>
                </div>

                <!-- Card Misi -->
                <div class="bg-slate-50 rounded-[32px] p-8 lg:p-10 text-slate-800 border border-slate-200 relative overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#5442F5]/10 rounded-full flex items-center justify-center text-xl mb-5">🚀</div>
                    <h3 class="text-2xl font-extrabold mb-4 tracking-tight">Misi Kami</h3>
                    <ul class="space-y-3 text-slate-600 font-medium text-sm leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-[#5442F5] text-white flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">1</span>
                            Menyelenggarakan program kerja yang relevan dengan perkembangan industri TI.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-[#5442F5] text-white flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">2</span>
                            Meningkatkan kualitas sumber daya mahasiswa melalui pelatihan dan kompetisi.
                        </li>
                    </ul>
                </div>
            </div>

            <div>
                <div class="text-center mb-10">
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Struktur Kepengurusan</h2>
                    <p class="text-slate-500 font-medium text-sm mt-2">Pilar utama penggerak roda organisasi HIMA Ilkom.</p>
                </div>

                @if($pengurusInti->isEmpty() && $divisiBesertaAnggota->isEmpty())
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px] p-10 text-center">
                        <span class="text-4xl mb-3 block">👥</span>
                        <p class="text-slate-500 font-bold text-sm">Data kepengurusan belum tersedia atau masih diproses.</p>
                    </div>
                @else
                    
                    @if($pengurusInti->isNotEmpty())
                        @php
                            // Urutkan BPH (Ketua -> Wakahim -> Sekre -> Bendum)
                            $urutanPrioritas = [
                                'ketua hima'   => 1,
                                'ketua'        => 1,
                                'wakahim'      => 2,
                                'wakil ketua'  => 2,
                                'sekretaris'   => 3,
                                'sekretaris 1' => 3,
                                'sekretaris 2' => 4,
                                'bendahara'    => 5,
                                'bendahara 1'  => 5,
                                'bendahara 2'  => 6,
                            ];

                            $pengurusInti = $pengurusInti->sortBy(function($bph) use ($urutanPrioritas) {
                                $jabatan = strtolower($bph->jabatan ?? $bph->position ?? $bph->getRoleNames()->first() ?? 'bph');
                                return $urutanPrioritas[$jabatan] ?? 99;
                            })->values();
                        @endphp

                        <div class="mb-14">
                            <div class="flex items-center justify-center gap-3 mb-8">
                                <div class="h-px bg-slate-200 w-12 lg:w-24"></div>
                                <h3 class="text-lg lg:text-xl font-black text-[#5442F5] uppercase tracking-widest text-center">Badan Pengurus Harian</h3>
                                <div class="h-px bg-slate-200 w-12 lg:w-24"></div>
                            </div>

                            <div class="flex flex-wrap justify-center gap-6 lg:gap-10">
                                @foreach($pengurusInti as $bph)
                                    @php
                                        // Olah Foto
                                        $foto = $bph->avatar ?? $bph->photo ?? $bph->foto;
                                        $fotoUrl = $foto ? asset('storage/'.$foto) : 'https://ui-avatars.com/api/?name='.urlencode($bph->name).'&background=5442F5&color=fff&size=400';
                                        
                                        // Tarik Data Buku Induk
                                        $mData = \Illuminate\Support\Facades\DB::table('members')->where('user_id', $bph->id)->first();
                                        $contact = $mData->emergency_contact ?? 'Belum diisi';
                                        $nimData = $mData->nim ?? $bph->nim ?? '-';
                                        $skills = !empty($mData->skills) ? json_decode($mData->skills, true) : [];
                                        if (!is_array($skills)) $skills = [];
                                    @endphp

                                    <div x-data="{ openModal: false }" class="group flex flex-col items-center text-center w-48">
                                        
                                        <div @click="openModal = true" class="relative w-full aspect-[4/5] rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl bg-indigo-50 mb-4 cursor-pointer border-4 border-white transition-all">
                                            <img src="{{ $fotoUrl }}" alt="{{ $bph->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                                <button class="translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 px-3 py-2.5 bg-[#5442F5] hover:bg-white text-white hover:text-[#5442F5] text-xs font-extrabold rounded-xl shadow-md w-full text-center flex items-center justify-center gap-1.5">
                                                    Lihat Profil
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <h4 class="font-extrabold text-slate-800 text-sm mb-1 leading-snug line-clamp-2">{{ $bph->name }}</h4>
                                        <span class="text-[11px] font-bold text-[#5442F5] mt-auto uppercase tracking-wider text-center">
                                            {{ $bph->jabatan ?? $bph->position ?? $bph->getRoleNames()->first() ?? 'BPH' }}
                                        </span>

                                        <template x-teleport="body">
                                            <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
                                                <div x-show="openModal" x-transition.opacity @click="openModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
                                                <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95" class="relative w-full max-w-sm bg-white rounded-[32px] shadow-2xl overflow-hidden z-10 flex flex-col">
                                                    <div class="h-28 bg-gradient-to-r from-[#5442F5] to-indigo-400 relative">
                                                        <button @click="openModal = false" class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-md">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                    <div class="px-8 pb-8 pt-0 relative flex flex-col items-center text-center">
                                                        <div class="w-24 h-24 -mt-12 mb-3 rounded-full border-4 border-white shadow-lg bg-white overflow-hidden relative z-10">
                                                            <img src="{{ $fotoUrl }}" alt="{{ $bph->name }}" class="w-full h-full object-cover">
                                                        </div>
                                                        <h2 class="text-xl font-black text-slate-800">{{ $bph->name }}</h2>
                                                        <p class="text-sm font-bold text-[#5442F5] mb-2">{{ $nimData }}</p>
                                                        <span class="bg-emerald-50 text-emerald-600 text-[10px] font-extrabold px-3 py-1 rounded-full mb-6 uppercase tracking-wider">Status: Aktif</span>
                                                        <div class="w-full text-left space-y-4 border-t border-slate-100 pt-5">
                                                            <div>
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kontak Darurat</p>
                                                                <p class="text-sm font-bold text-slate-700">{{ $contact }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Keahlian (Skills)</p>
                                                                <div class="flex flex-wrap gap-1.5">
                                                                    @forelse($skills as $skill)
                                                                        <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-bold px-2.5 py-1 rounded-md">{{ $skill }}</span>
                                                                    @empty
                                                                        <span class="text-xs text-slate-400 italic font-medium">Belum ada data keahlian.</span>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="space-y-12">
                        @foreach($divisiBesertaAnggota as $divisi)
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <h3 class="text-lg lg:text-xl font-extrabold text-slate-800 uppercase tracking-tight">Divisi {{ $divisi->singkatan }}</h3>
                                    <div class="h-px bg-slate-200 flex-grow"></div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-5">
                                    @foreach($divisi->anggota as $pengurus)
                                        @php
                                            $foto = $pengurus->avatar ?? $pengurus->photo ?? $pengurus->foto;
                                            $fotoUrl = $foto ? asset('storage/'.$foto) : 'https://ui-avatars.com/api/?name='.urlencode($pengurus->name).'&background=5442F5&color=fff&size=400';
                                            
                                            $mData = \Illuminate\Support\Facades\DB::table('members')->where('user_id', $pengurus->id)->first();
                                            $contact = $mData->emergency_contact ?? 'Belum diisi';
                                            $nimData = $mData->nim ?? $pengurus->nim ?? '-';
                                            $skills = !empty($mData->skills) ? json_decode($mData->skills, true) : [];
                                            if (!is_array($skills)) $skills = [];
                                        @endphp

                                        <div x-data="{ openModal: false }" class="group flex flex-col items-center text-center">
                                            
                                            <div @click="openModal = true" class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden shadow-sm hover:shadow-lg bg-slate-50 mb-3 cursor-pointer border-2 border-white transition-all">
                                                <img src="{{ $fotoUrl }}" alt="{{ $pengurus->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                                                    <button class="translate-y-3 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 px-2 py-2 bg-white text-[#5442F5] hover:bg-[#5442F5] hover:text-white text-[10px] font-extrabold rounded-lg shadow-sm w-full text-center">
                                                        Profil
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <h4 class="font-bold text-slate-800 text-[13px] mb-1 leading-snug line-clamp-2">{{ $pengurus->name }}</h4>
                                            <span class="px-2 py-1 bg-slate-50 text-slate-500 text-[9px] font-bold rounded-md uppercase tracking-wider mt-auto">
                                                {{ $pengurus->getRoleNames()->first() ?? 'Anggota' }}
                                            </span>

                                            <template x-teleport="body">
                                                <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
                                                    <div x-show="openModal" x-transition.opacity @click="openModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
                                                    <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95" class="relative w-full max-w-sm bg-white rounded-[32px] shadow-2xl overflow-hidden z-10 flex flex-col text-center">
                                                        <div class="h-28 bg-gradient-to-r from-slate-700 to-slate-900 relative">
                                                            <button @click="openModal = false" class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-md">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>
                                                        <div class="px-8 pb-8 pt-0 relative flex flex-col items-center text-center">
                                                            <div class="w-24 h-24 -mt-12 mb-3 rounded-full border-4 border-white shadow-lg bg-white overflow-hidden relative z-10">
                                                                <img src="{{ $fotoUrl }}" alt="{{ $pengurus->name }}" class="w-full h-full object-cover">
                                                            </div>
                                                            <h2 class="text-xl font-black text-slate-800">{{ $pengurus->name }}</h2>
                                                            <p class="text-sm font-bold text-slate-500 mb-2">{{ $nimData }}</p>
                                                            <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-extrabold px-3 py-1 rounded-full mb-6 uppercase tracking-wider">Divisi {{ $divisi->singkatan }}</span>
                                                            <div class="w-full text-left space-y-4 border-t border-slate-100 pt-5">
                                                                <div>
                                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kontak Darurat</p>
                                                                    <p class="text-sm font-bold text-slate-700">{{ $contact }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Keahlian (Skills)</p>
                                                                    <div class="flex flex-wrap gap-1.5">
                                                                        @forelse($skills as $skill)
                                                                            <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-bold px-2.5 py-1 rounded-md">{{ $skill }}</span>
                                                                        @empty
                                                                            <span class="text-xs text-slate-400 italic font-medium">Belum ada data keahlian.</span>
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 4. BERITA TERBARU (CMS Portal)             -->
    <!-- ========================================== -->
    <section id="berita" class="py-20 px-4 sm:px-6 lg:px-12 max-w-[1200px] mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Berita & Publikasi</h2>
            <p class="text-slate-500 font-medium text-sm mt-2">Informasi terkini seputar program kerja dan kegiatan HIMA.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($beritaTerbaru as $news)
                <!-- Card Berita (Modern Layout) -->
                <div class="bg-white rounded-[32px] p-4 shadow-sm hover:shadow-xl border border-slate-100 hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full animate-fade-in-up">
                    <div class="w-full h-48 rounded-[24px] overflow-hidden mb-5 relative bg-slate-100">
                        @php
                            $gambarNews = $news->thumbnail ?? $news->image ?? $news->gambar ?? '';
                            $pathGambar = str_starts_with($gambarNews, 'storage') ? asset($gambarNews) : asset('storage/' . $gambarNews);
                        @endphp
                        @if(!empty($gambarNews))
                            <img src="{{ $pathGambar }}" onerror="this.outerHTML='<div class=\'w-full h-full flex items-center justify-center text-4xl\'>📰</div>'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl">📰</div>
                        @endif
                        
                        <!-- Badge Tanggal -->
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-bold text-[#5442F5] shadow-sm uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($news->created_at ?? $news->date)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                    
                    <div class="px-2 flex-grow flex flex-col">
                        <!-- Penulis -->
                        <div class="flex items-center gap-2 mb-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <span class="text-slate-300">✍️</span> {{ $news->penulis ?? $news->author ?? 'Tim Kominfo' }}
                        </div>
                        
                        <!-- Judul -->
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 group-hover:text-[#5442F5] transition-colors line-clamp-2 leading-snug">{{ $news->title }}</h3>
                        
                        <!-- Ringkasan Singkat (Maks 2 Baris) -->
                        <p class="text-sm font-medium text-slate-500 line-clamp-2 mb-6">
                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($news->content ?? $news->body ?? $news->deskripsi ?? '')), 80) }}
                        </p>
                        
                        <!-- Tombol Baca -->
                        <a href="{{ route('superadmin.news.show', $news->slug ?? $news->id) }}" class="mt-auto px-5 py-2.5 bg-slate-50 hover:bg-[#5442F5] hover:text-white text-[#5442F5] font-bold text-xs rounded-full transition-all w-fit flex items-center gap-2">
                            Baca Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 rounded-[32px]">
                    <span class="text-4xl mb-3 block">📝</span>
                    <p class="text-sm font-bold text-slate-400">Belum ada artikel berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center">
            <!-- Asumsi route index publik (bukan superadmin) ada. Jika belum, biarkan '#' -->
            <a href="#" class="inline-flex items-center gap-2 px-8 py-4 bg-white border border-slate-200 hover:border-[#5442F5] text-slate-700 hover:text-[#5442F5] text-sm font-bold rounded-full transition-all shadow-sm">
                Lihat Semua Berita <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m-7-7H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. FAQ (Accordion AlpineJS)                -->
    <!-- ========================================== -->
    <section id="faq" class="py-20 px-4 sm:px-6 lg:px-12 bg-slate-50">
        <div class="max-w-[800px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Pertanyaan Umum (FAQ)</h2>
                <p class="text-slate-500 font-medium text-sm mt-2">Dapatkan jawaban cepat untuk pertanyaan yang paling sering diajukan.</p>
            </div>
            
            <!-- Logika active: null akan membuat accordion tertutup otomatis bila yg lain dibuka -->
            <div class="space-y-4" x-data="{ active: null }">
                
                <!-- FAQ 1 -->
                <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm hover:border-indigo-200 transition-colors">
                    <button @click="active = active === 1 ? null : 1" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 pr-4">Apa itu Himpunan Mahasiswa Ilmu Komputer?</span>
                        <svg class="w-5 h-5 text-[#5442F5] transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': active === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="px-6 pb-6 text-sm font-medium text-slate-500 leading-relaxed border-t border-slate-50 mt-2 pt-4">
                            HIMA Ilmu Komputer adalah organisasi mahasiswa tingkat program studi yang menaungi, memfasilitasi, dan mengembangkan minat bakat mahasiswa Ilmu Komputer di bidang akademik maupun non-akademik.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm hover:border-indigo-200 transition-colors">
                    <button @click="active = active === 2 ? null : 2" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 pr-4">Bagaimana cara bergabung menjadi anggota HIMA?</span>
                        <svg class="w-5 h-5 text-[#5442F5] transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': active === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="px-6 pb-6 text-sm font-medium text-slate-500 leading-relaxed border-t border-slate-50 mt-2 pt-4">
                            Pendaftaran (Open Recruitment) biasanya diadakan setiap pergantian periode pengurus. Anda dapat mengklik tombol "Daftar" di website ini dan menunggu verifikasi dari badan pengurus.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm hover:border-indigo-200 transition-colors">
                    <button @click="active = active === 3 ? null : 3" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 pr-4">Siapa yang dapat mengikuti kegiatan HIMA?</span>
                        <svg class="w-5 h-5 text-[#5442F5] transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': active === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="px-6 pb-6 text-sm font-medium text-slate-500 leading-relaxed border-t border-slate-50 mt-2 pt-4">
                            Seluruh program kerja skala besar terbuka untuk seluruh mahasiswa aktif program studi Ilmu Komputer. Namun, ada rapat dan evaluasi khusus yang hanya bisa diakses oleh pengurus struktural.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm hover:border-indigo-200 transition-colors">
                    <button @click="active = active === 4 ? null : 4" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 pr-4">Bagaimana cara menghubungi pengurus?</span>
                        <svg class="w-5 h-5 text-[#5442F5] transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': active === 4}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 4" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="px-6 pb-6 text-sm font-medium text-slate-500 leading-relaxed border-t border-slate-50 mt-2 pt-4">
                            Anda dapat menemui kami di sekretariat, mengirim pesan ke email resmi kami, atau klik tombol Hubungi via WhatsApp pada bagian Kontak di halaman ini.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm hover:border-indigo-200 transition-colors">
                    <button @click="active = active === 5 ? null : 5" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 pr-4">Apakah seluruh kegiatan HIMA gratis?</span>
                        <svg class="w-5 h-5 text-[#5442F5] transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': active === 5}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 5" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="px-6 pb-6 text-sm font-medium text-slate-500 leading-relaxed border-t border-slate-50 mt-2 pt-4">
                            Sebagian besar kegiatan pelatihan, forum diskusi, dan kompetisi internal tidak dipungut biaya. Biaya pendaftaran hanya berlaku pada acara-acara besar seperti Malam Keakraban (Makrab) atau Seminar Nasional.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. KONTAK & LOKASI                         -->
    <!-- ========================================== -->
    <section id="kontak" class="py-20 px-4 sm:px-6 lg:px-12 max-w-[1200px] mx-auto">
        <div class="bg-white rounded-[40px] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                
                <!-- Kolom Kiri: Info Kontak -->
                <div class="p-10 lg:p-14">
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2 tracking-tight">Hubungi Kami</h2>
                    <p class="text-sm font-medium text-slate-500 mb-10">Punya pertanyaan, ide kolaborasi, atau butuh bantuan sistem? Jangan ragu untuk menyapa kami.</p>

                    <div class="space-y-6">
                        <!-- Nama & Alamat -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-indigo-50 text-[#5442F5] rounded-full flex items-center justify-center flex-shrink-0 text-xl">📍</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 mb-1">Sekretariat Himpunan</h4>
                                <p class="text-sm font-medium text-slate-500 leading-relaxed">Laborat Jaringan Komputer, Kampus 1 Universitas Muhammadaiyah Kudus, Jawa Tengah.</p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-50 text-[#5442F5] rounded-full flex items-center justify-center flex-shrink-0 text-xl">📧</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 mb-1">Email Resmi</h4>
                                <p class="text-sm font-medium text-slate-500">himailkom@kampus.ac.id</p>
                            </div>
                        </div>
                        <!-- WhatsApp -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-50 text-[#5442F5] rounded-full flex items-center justify-center flex-shrink-0 text-xl">💬</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 mb-1">WhatsApp Center</h4>
                                <p class="text-sm font-medium text-slate-500">+62 818 0920 8710</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <a href="https://wa.me/6281809208710" target="_blank" class="mt-10 inline-flex items-center gap-2 px-8 py-4 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-[#5442F5]/30">
                        Hubungi via WhatsApp <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m-7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Kolom Kanan: Google Maps -->
                <div class="h-[400px] lg:h-auto w-full bg-slate-50 relative p-4 lg:p-6 lg:pl-0">
                    <div class="w-full h-full rounded-[32px] overflow-hidden shadow-inner border border-slate-200">
    <!-- Embed Google Maps yang menunjuk ke Universitas Muhammadiyah Kudus -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d713.9559977433576!2d110.82401598512571!3d-6.8063064596187335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70c4ba19d86303%3A0x8ae836e251f90fe3!2sUniversity%20Muhammadiyah%20of%20Kudus!5e0!3m2!1sen!2sid!4v1784078197054!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
</div>

                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 7. FOOTER                                  -->
    <!-- ========================================== -->
    <footer class="bg-slate-900 pt-20 pb-10 text-slate-300">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Kolom 1: Tentang Logo -->
                <div class="lg:col-span-1">
                    <a href="#" class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<div class=\'w-10 h-10 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg\'>H</div>'" alt="Logo HIMA" class="w-10 h-10 object-contain bg-white rounded-xl p-1">
                        <span class="font-extrabold text-xl tracking-tight text-white">HIMA <span class="text-[#818CF8]">ILMU KOMPUTER</span></span>
                    </a>
                    <p class="text-sm font-medium text-slate-400 leading-relaxed">
                        Pusat informasi, publikasi, dan administrasi organisasi mahasiswa Ilmu Komputer untuk menciptakan generasi yang inovatif dan kolaboratif.
                    </p>
                </div>

                <!-- Kolom 2: Navigasi -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Navigasi</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li><a href="#beranda" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Tentang</a></li>
                        <li><a href="#berita" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Berita</a></li>
                        <li><a href="#faq" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> FAQ</a></li>
                        <li><a href="#kontak" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Kontak</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Kontak</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            himailkom.umku@gmail.com
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 818 0920 8710
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Laborat Jaringan Komputer Kampus 1 UMKU
                        </li>
                    </ul>
                </div>

                <!-- Kolom 4: Media Sosial -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Media Sosial</h4>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/himailkom.umku?igsh=dWtldHRjMzExNjB0" title="Instagram" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-[#E1306C] flex items-center justify-center transition-colors text-white font-bold text-xs">IG</a>
                        <a href="#" title="TikTok" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-black flex items-center justify-center transition-colors text-white font-bold text-xs">TK</a>
                        <a href="#" title="YouTube" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-[#FF0000] flex items-center justify-center transition-colors text-white font-bold text-xs">YT</a>
                        <a href="#" title="LinkedIn" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-[#0077b5] flex items-center justify-center transition-colors text-white font-bold text-xs">IN</a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                <p class="text-sm font-medium text-slate-500">© 2026 Himpunan Mahasiswa Ilmu Komputer. All Rights Reserved.</p>
                <div class="text-sm font-medium text-slate-500 flex gap-4 justify-center">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
            
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- Tombol Back to Top                         -->
    <!-- ========================================== -->
    <button 
        x-show="scrolled" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-8 right-8 w-12 h-12 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-full flex items-center justify-center shadow-lg shadow-[#5442F5]/40 z-50 transition-colors"
        style="display: none;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
    </button>

</body>
</html>

    </body>
</html>