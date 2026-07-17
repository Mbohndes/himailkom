@extends('layouts.superadmin')
@section('title', 'Panduan Sistem & Informasi')

@section('content')
<div class="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-12 pt-4">

    <div class="bg-gradient-to-br from-[#5442F5] to-indigo-600 rounded-[32px] p-10 shadow-lg shadow-indigo-200 relative overflow-hidden text-white">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 text-center sm:text-left flex flex-col sm:flex-row items-center gap-6">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-tight mb-2">Pusat Bantuan & Informasi</h1>
                <p class="text-indigo-100 font-medium text-sm md:text-base max-w-xl">
                    Pelajari cara menggunakan Sistem Informasi HIMA ILKOM atau tanyakan langsung pada asisten cerdas kami.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 text-center">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Dikembangkan Oleh</h3>
                
                <div class="w-24 h-24 mx-auto bg-indigo-50 rounded-[1.5rem] p-1 shadow-inner mb-4 rotate-3 hover:rotate-0 transition-transform duration-300">
                    <img src="https://ui-avatars.com/api/?name=Riski+Kurniawan&background=5442F5&color=fff&size=150" alt="Riski Kurniawan" class="w-full h-full object-cover rounded-2xl">
                </div>
                
                <h2 class="text-xl font-black text-slate-800">Riski Kurniawan</h2>
                <p class="text-sm font-bold text-[#5442F5] mt-1 mb-4">Mahasiswa Ilmu Komputer</p>
                
                <p class="text-xs text-slate-500 font-medium leading-relaxed bg-slate-50 p-4 rounded-2xl">
                    Sistem ini dibangun untuk mendigitalisasi dan mempermudah tata kelola administrasi, program kerja, dan keanggotaan HIMA ILKOM.
                </p>
            </div>

            <a href="#" class="flex items-center gap-4 bg-white rounded-[24px] p-5 shadow-sm border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50 transition-colors group">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-800">Laporkan Bug (Error)</h4>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Hubungi pengembang</p>
                </div>
            </a>
        </div>

        <div class="lg:col-span-2 space-y-8">
            
            <!-- Widget Chat AI -->
<div x-data="{ messages: [{role: 'ai', text: 'Halo! Saya asisten AI HIMA Bernama AIWAN. Ada yang bisa saya bantu terkait sistem?'}], input: '' }" class="fixed bottom-6 right-6 z-50 w-80 shadow-2xl rounded-3xl overflow-hidden bg-white border border-slate-200">
    <!-- Header -->
    <div class="bg-indigo-600 p-4 text-white font-bold text-sm">Asisten AIWAN</div>
    
    <!-- Chat Area -->
    <!-- Chat Area -->
    <div id="chatboxHima" class="h-64 overflow-y-auto p-4 space-y-3 bg-slate-50">
        <template x-for="msg in messages">
            <div :class="msg.role === 'ai' ? 'text-left' : 'text-right'">
                <span class="inline-block p-3 rounded-2xl text-xs font-medium" 
                      :class="msg.role === 'ai' ? 'bg-white text-slate-700 shadow-sm' : 'bg-[#5442F5] text-white'">
                    <span x-text="msg.text"></span>
                </span>
            </div>
        </template>
    </div>

    <!-- Input Area -->
    <!-- Input Area -->
    <form @submit.prevent="
        if(input.trim() === '') return;
        const userMsg = input;
        
        // 1. Masukkan pesan user & kosongkan input
        messages.push({role: 'user', text: userMsg});
        input = '';
        
        // 2. Auto-scroll ke pesan user
        $nextTick(() => { 
            let box = document.getElementById('chatboxHima'); 
            box.scrollTop = box.scrollHeight; 
        });

        // 3. Tampilkan tulisan 'Mengetik...' agar tidak dikira nge-lag
        messages.push({role: 'ai', text: 'Sedang mengetik...', isTyping: true});
        $nextTick(() => { 
            let box = document.getElementById('chatboxHima'); 
            box.scrollTop = box.scrollHeight; 
        });

        // 4. Kirim ke server
        fetch('/ai-chat', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({message: userMsg})
        })
        .then(r => r.json())
        .then(data => {
            // Hapus tulisan 'Sedang mengetik...'
            messages.pop(); 
            
            // Masukkan balasan asli dari AI HIMA
            if(data.error) {
                messages.push({role: 'ai', text: 'Maaf: ' + data.message});
            } else if (data.candidates && data.candidates.length > 0) {
                messages.push({role: 'ai', text: data.candidates[0].content.parts[0].text});
            } else {
                messages.push({role: 'ai', text: 'Maaf, sistem sedang sibuk.'});
            }

            // 5. Auto-scroll lagi setelah AI selesai membalas
            $nextTick(() => { 
                let box = document.getElementById('chatboxHima'); 
                box.scrollTop = box.scrollHeight; 
            });
        })
        .catch(err => {
            messages.pop();
            messages.push({role: 'ai', text: 'Terjadi kesalahan jaringan lokal.'});
        });
    " class="p-3 border-t bg-white">
        <input x-model="input" type="text" placeholder="Tanya sistem..." class="w-full text-xs border-0 focus:ring-0 outline-none">
    </form>
</div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="text-[#5442F5]">📖</span> Panduan Cepat Penggunaan
                </h3>
                
                <div class="space-y-4">
                    <details class="group bg-slate-50 rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-800 font-bold">
                            Tugas Master Data
                            <span class="transition duration-300 group-open:-rotate-180 text-[#5442F5]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0 text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-200/60 mt-2 pt-4">
                            Selalu pastikan Master Data (Periode, Divisi, dan Jabatan) sudah terisi sebelum menambahkan Anggota atau Program Kerja baru agar sistem tidak mengalami error relasi.
                        </div>
                    </details>

                    <details class="group bg-slate-50 rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-800 font-bold">
                            Cara Update Buku Induk Profil
                            <span class="transition duration-300 group-open:-rotate-180 text-[#5442F5]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0 text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-200/60 mt-2 pt-4">
                            Setiap anggota dapat memperbarui foto, menambahkan keahlian (pisahkan dengan koma), dan mencatat prestasi secara mandiri melalui menu <b>Profil Saya</b> di pojok kiri bawah.
                        </div>
                    </details>
                    
                    <details class="group bg-slate-50 rounded-2xl [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-800 font-bold">
                            Hak Akses (Role & Permission)
                            <span class="transition duration-300 group-open:-rotate-180 text-[#5442F5]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </span>
                        </summary>
                        <div class="px-5 pb-5 pt-0 text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-200/60 mt-2 pt-4">
                            Hanya akun dengan hak akses <b>Super Admin</b> atau <b>BPH</b> yang dapat menghapus data penting. Divisi biasa hanya dapat melihat dan menambah laporan pada modul masing-masing.
                        </div>
                    </details>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection