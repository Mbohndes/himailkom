<x-app-layout>
    <div class="py-12 bg-[#F4F7FE] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-6">
            
            <div class="bg-gradient-to-r from-[#5442F5] to-indigo-800 rounded-[30px] p-8 md:p-10 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <span class="bg-white/20 border border-white/30 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block shadow-sm">
                        {{ auth()->user()->roles->pluck('name')->first() ?? 'Anggota HIMA' }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black mb-2">Selamat datang, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
                    <p class="text-indigo-100 font-medium max-w-xl text-sm md:text-base leading-relaxed">
                        Ini adalah ruang khusus keanggotaan HIMA ILKOM. Di sini Anda bisa memantau agenda kegiatan organisasi, serta mengecek status tagihan iuran kas Anda.
                    </p>
                </div>
                
                <svg class="absolute -bottom-10 -right-10 w-64 h-64 text-white opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                
                <a href="#" class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all group flex items-center gap-4">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Tagihan Iuran</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Cek status kas bulanan</p>
                    </div>
                </a>

                <a href="#" class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all group flex items-center gap-4">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Agenda Kegiatan</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Jadwal proker & presensi</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all group flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Profil Saya</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Update data mahasiswa</p>
                    </div>
                </a>
                
            </div>
        </div>
    </div>
</x-app-layout>