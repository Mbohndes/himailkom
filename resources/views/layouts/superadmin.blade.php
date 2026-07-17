<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HIMA ILMU KOMPUTER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F4F7FE; 
        }
        
        /* Global Touch Target Standard (Mobile Friendly) */
        @media (max-width: 1024px) {
            button, select, input, a.btn {
                min-height: 44px; /* Standar minimal sentuhan jari (Apple HIG) */
            }
            /* Mencegah tabel melebar berantakan di layar kecil */
            td, th { white-space: nowrap; }
        }

        /* Custom Scrollbar Estetik */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden bg-[#F4F7FE]">

        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-sm" 
             @click="sidebarOpen = false" style="display: none;">
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-[260px] bg-white lg:bg-transparent h-full flex-shrink-0 flex flex-col justify-between px-6 py-8 overflow-y-auto transform transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-2xl lg:shadow-none">
            
            <div>
                <div class="flex items-center justify-between mb-8 px-4 gap-4">
                    
    <!-- Perbaikan: Mengubah min-w-0 menjadi w-full/flex-1 agar teks punya ruang maksimal -->
    <a href="#" class="flex items-center gap-3 group flex-1 min-w-0">
        <img src="{{ asset('logo.png') }}" 
            onerror="this.outerHTML='<div class=\'w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg flex-shrink-0\'>H</div>'" 
            alt="Logo HIMA" 
            class="w-10 h-10 sm:w-14 sm:h-14 object-contain group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
        
        <!-- Perbaikan: Menggunakan leading-tight dan whitespace-nowrap/normal agar teks proporsional -->
        <span class="font-extrabold text-base sm:text-xl tracking-tight transition-colors text-slate-800 leading-tight block">
            HIMA <span class="text-[#5442F5] block sm:inline">ILMU KOMPUTER</span>
        </span>
    </a>

    <button @click="sidebarOpen = false" class="lg:hidden p-2 -mr-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all flex-shrink-0 outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    
</div>
                
                <nav class="space-y-6 pb-20"> 
                    
                    <div>
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">MENU UTAMA</p>
                        <div class="space-y-1">
                            <a href="{{ route('superadmin.dashboard') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#5442F5] text-white shadow-md shadow-indigo-200' : 'text-slate-500 hover:bg-indigo-50 hover:text-[#5442F5]' }} rounded-2xl font-semibold text-sm transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard
                            </a>
                        </div>
                    </div>

                    @role('Super Admin')
                    <div>
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">MASTER DATA</p>
                        <div class="space-y-1">
                            <a href="{{ route('superadmin.masterdata.periods.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Periode Kepengurusan
                            </a>
                            <a href="{{ route('superadmin.divisions.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                                  <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Divisi
                            </a>
                            <a href="{{ route('superadmin.positions.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                               <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Jabatan
                            </a>
                        </div>
                    </div>
                    @endrole

                    @hasanyrole('Super Admin|BPH|Kepala Divisi')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">KEANGGOTAAN</p>
                        <div class="space-y-1" x-data="{ openMember: {{ request()->routeIs('superadmin.membership.*') ? 'true' : 'false' }} }">
                            <button @click="openMember = !openMember" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                 <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Manajemen Anggota
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openMember ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="openMember" x-collapse class="pl-11 pr-4 py-1 space-y-1">
                                @role('Super Admin')
                                    <a href="{{ route('superadmin.membership.applications.index') }}" class="block py-1.5 text-xs font-bold text-[#5442F5] transition-colors">Pendaftaran Mahasiswa</a>
                                    <a href="{{ route('superadmin.membership.users.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Manajemen Pengguna</a>
                                @endrole
                                
                                @hasanyrole('Super Admin|BPH|Kepala Divisi')
                                    <a href="{{ route('superadmin.membership.data.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Data Anggota</a>
                                @endhasanyrole
                                
                                @hasanyrole('Super Admin|BPH')
                                    <a href="{{ route('superadmin.membership.alumni.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Data Alumni</a>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>
                    @endhasanyrole

                    @hasanyrole('Super Admin|BPH')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">PELAPORAN & EXPORT</p>
                        <div class="space-y-1" x-data="{ openReport: {{ request()->routeIs('superadmin.reports.*') ? 'true' : 'false' }} }">
                            <button @click="openReport = !openReport" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Pusat Laporan
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openReport ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="openReport" x-collapse class="pl-11 pr-4 py-1 space-y-1">
                                <a href="{{ route('superadmin.reports.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Dashboard Laporan</a>
                                <a href="{{ route('superadmin.reports.members') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Laporan Anggota</a>
                                <a href="{{ route('superadmin.reports.programs') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Laporan Program Kerja</a>
                                <a href="{{ route('superadmin.reports.finance') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Laporan Keuangan</a>
                                <a href="{{ route('superadmin.reports.activity') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Laporan Keaktifan</a>
                            </div>
                        </div>
                    </div>
                    @endhasanyrole

                    @hasanyrole('Super Admin|BPH|Kepala Divisi')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">OPERASIONAL</p>
                        <div class="space-y-1" x-data="{ openProker: {{ request()->routeIs('superadmin.prokers.*') ? 'true' : 'false' }} }">
                            <button @click="openProker = !openProker" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Program Kerja
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openProker ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="openProker" x-collapse class="pl-11 pr-4 py-1 space-y-1">
                                <a href="{{ route('superadmin.prokers.dashboard') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Dashboard Proker</a>
                                <a href="{{ route('superadmin.prokers.index') }}" class="block py-1.5 text-xs font-medium {{ request()->routeIs('superadmin.prokers.index') ? 'text-[#5442F5] font-bold' : 'text-slate-500' }} hover:text-[#5442F5] transition-colors">Data Proker</a>
                            </div>
                            
                            <a href="{{ route('superadmin.agendas.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Agenda
                            </a>
                        </div>
                    </div>
                    @endhasanyrole 

                    @hasanyrole('Super Admin|BPH|Kepala Divisi')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">PUBLIKASI & MEDIA</p>
                        <div class="space-y-1" x-data="{ openNews: {{ request()->routeIs('superadmin.news.*') ? 'true' : 'false' }} }">
                            <button @click="openNews = !openNews" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                                    Portal CMS
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openNews ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="openNews" x-collapse class="pl-11 pr-4 py-1 space-y-1">
                                <a href="{{ route('superadmin.news.dashboard') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Dashboard Berita</a>
                                <a href="{{ route('superadmin.news.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Semua Berita</a>
                                <a href="{{ route('superadmin.news.categories.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Kategori</a>
                                <a href="{{ route('superadmin.news.tags.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Tag</a>
                            </div>
                        </div>
                    </div>
                    @endhasanyrole

                    @hasanyrole('Super Admin|BPH|Kepala Divisi|Anggota')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">KEUANGAN & DOKUMENTASI</p>
                        
                        @unlessrole('Kepala Divisi')
                        <div class="space-y-1" x-data="{ openFinance: {{ request()->routeIs('superadmin.finance.*') ? 'true' : 'false' }} }">
                            <button @click="openFinance = !openFinance" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Kas & Keuangan
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openFinance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="openFinance" x-collapse class="pl-11 pr-4 py-1 space-y-2">
                                <a href="{{ route('superadmin.finance.dashboard') }}" class="block py-1 text-xs font-bold text-slate-500 hover:text-[#5442F5] transition-colors">Dashboard Keuangan</a>
                                
                                @hasanyrole('Super Admin|BPH')
                                <div x-data="{ openTransaksi: false }">
                                    <button @click="openTransaksi = !openTransaksi" class="w-full flex items-center justify-between py-1 text-xs font-bold text-slate-500 hover:text-[#5442F5] transition-colors outline-none">
                                        Transaksi Umum
                                        <svg class="w-3 h-3 transition-transform duration-200" :class="openTransaksi ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="openTransaksi" x-collapse class="pl-3 mt-1 space-y-1 border-l border-slate-200">
                                        <a href="{{ route('superadmin.finance.incomes.index') }}" class="block py-1 text-xs font-medium text-slate-500 hover:text-[#5442F5]">Pemasukan</a>
                                        <a href="{{ route('superadmin.finance.expenses.index') }}" class="block py-1 text-xs font-medium text-slate-500 hover:text-[#5442F5]">Pengeluaran</a>
                                    </div>
                                </div>
                                @endhasanyrole

                                <div x-data="{ openIuran: true }">
                                    <button @click="openIuran = !openIuran" class="w-full flex items-center justify-between py-1 text-xs font-bold text-slate-500 hover:text-[#5442F5] transition-colors outline-none">
                                        Iuran Anggota
                                        <svg class="w-3 h-3 transition-transform duration-200" :class="openIuran ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="openIuran" x-collapse class="pl-3 mt-1 space-y-1 border-l border-slate-200">
                                        @unlessrole('Anggota')
                                            <a href="{{ route('superadmin.finance.dues.index') }}" class="block py-1 text-xs font-medium text-slate-500 hover:text-[#5442F5]">Master Iuran</a>
                                        @endunlessrole
                                        <a href="{{ route('superadmin.finance.payments') }}" class="block py-1 text-xs font-medium text-slate-500 hover:text-[#5442F5]">{{ auth()->user()->hasRole('Anggota') ? 'Tagihan Saya' : 'Pembayaran Iuran' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endunlessrole

                        <a href="{{ route('superadmin.archives.index') }}" class="mt-1 w-full flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            Arsip Digital
                        </a>

                        <div class="space-y-1 mt-1" x-data="{ openGaleri: {{ request()->routeIs('superadmin.gallery.*') ? 'true' : 'false' }} }">
                            <button @click="openGaleri = !openGaleri" class="w-full flex items-center justify-between px-4 py-2 text-slate-500 hover:text-[#5442F5] hover:bg-indigo-50/50 rounded-2xl font-medium text-sm transition-all outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Galeri HIMA
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="openGaleri ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="openGaleri" x-collapse class="pl-11 pr-4 py-1 space-y-1">
                                <a href="{{ route('superadmin.gallery.index') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Semua Album</a>
                                @unlessrole('Anggota')
                                    <a href="{{ route('superadmin.gallery.create') }}" class="block py-1.5 text-xs font-medium text-slate-500 hover:text-[#5442F5] transition-colors">Tambah Album</a>
                                @endunlessrole
                            </div>
                        </div>
                    </div>
                    @endhasanyrole

                    @role('Super Admin')
                    <div class="mt-4">
                        <p class="px-4 text-[11px] font-bold text-slate-400 tracking-wider mb-2">SISTEM</p>
                        <div class="space-y-1">
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pengaturan Web
                            </a>
                            <a href="{{ route('superadmin.activity_logs.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Activity Log
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-slate-800 rounded-2xl font-medium text-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Backup DB
                            </a>
                        </div>
                    </div>
                    @endrole

                    <div class="border-t border-slate-100 pt-4 mt-6">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-[#5442F5] rounded-2xl font-medium text-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Saya
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-2xl font-medium text-sm transition-all outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>

                </nav>
            </div>
            
            <a href="{{ route('panduan.sistem') }}" class="group flex items-center gap-3 px-4 py-3.5 bg-indigo-50/50 hover:bg-[#5442F5] text-[#5442F5] hover:text-white text-sm font-bold rounded-2xl transition-all duration-300 shadow-sm mt-4">
        <div class="w-8 h-8 rounded-xl bg-white group-hover:bg-white/20 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4 text-[#5442F5] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        Panduan Sistem
    </a>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            
    <header class="flex items-center justify-between px-4 py-3 bg-white shadow-sm lg:hidden z-30 border-b border-slate-100">
        <!-- Perbaikan: Menghapus mb-10 dan memastikan w-full/flex-1 agar rata kanan-kiri -->
        <div class="flex items-center gap-3">
            <a href="#" class="flex items-center gap-3 group">
                <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<div class=\'w-14 h-14 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg\'>H</div>'" alt="Logo HIMA" class="w-14 h-14 object-contain group-hover:scale-110 transition-transform duration-300">
                <span class="font-extrabold text-xl tracking-tight transition-colors">HIMA <span class="text-[#5442F5]">ILMU KOMPUTER</span></span>
            </a>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.edit') }}" class="w-9 h-9 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </a>
            
            <button @click="sidebarOpen = true" class="text-slate-500 hover:text-[#5442F5] focus:outline-none p-1">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
        @yield('content')
    </main>

</div>


    </div>

</body>
<footer class="mt-auto py-6 px-4 md:px-8 text-center border-t border-slate-200/60 bg-white/50 backdrop-blur-sm">
                <p class="text-sm text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Sistem Informasi HIMA ILMU KOMPUTER. <br class="sm:hidden">
                    Dibuat <span class="text-red-500 animate-pulse"></span> oleh <span class="font-extrabold text-[#5442F5]">Riski Kurniawan</span>.
                </p>
            </footer>
</html>