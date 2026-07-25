<footer class="bg-slate-900 pt-20 pb-10 text-slate-300">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="lg:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<div class=\'w-10 h-10 bg-gradient-to-br from-[#5442F5] to-[#8066FF] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg\'>H</div>'" alt="Logo HIMA" class="w-10 h-10 object-contain bg-white rounded-xl p-1">
                    <span class="font-extrabold text-xl tracking-tight text-white">HIMA <span class="text-[#818CF8]">ILKOM</span></span>
                </a>
                <p class="text-sm font-medium text-slate-400 leading-relaxed">
                    Pusat informasi, publikasi, dan administrasi organisasi mahasiswa Ilmu Komputer.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Navigasi</h4>
                <ul class="space-y-4 text-sm font-medium text-slate-400">
                    <li><a href="{{ url('/#beranda') }}" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Beranda</a></li>
                    <li><a href="{{ url('/#tentang') }}" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Tentang</a></li>
                    <li><a href="{{ url('/#berita') }}" class="hover:text-[#818CF8] transition-colors flex items-center gap-2"><span class="text-[#5442F5]">▸</span> Berita</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Kontak</h4>
                <ul class="space-y-4 text-sm font-medium text-slate-400">
                    <li class="flex items-start gap-3">himailkom.umku@gmail.com</li>
                    <li class="flex items-start gap-3">+62 818 0920 8710</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Sosial Media</h4>
                <div class="flex gap-3">
                    <a href="https://www.instagram.com/himailkom.umku?igsh=dWtldHRjMzExNjB0" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-[#E1306C] flex items-center justify-center text-white font-bold text-xs transition-colors">IG</a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-8 text-center md:text-left text-sm font-medium text-slate-500">
            <p>© {{ date('Y') }} Himpunan Mahasiswa Ilmu Komputer. All Rights Reserved.</p>
        </div>
    </div>
</footer>