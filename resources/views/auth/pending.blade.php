<x-guest-layout>
    <div class="text-center pb-4">
        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-4 border-amber-50">
            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Pendaftaran Berhasil!</h2>
        <p class="text-sm font-medium text-slate-500 mb-6 leading-relaxed">
            Akun Anda dengan email <span class="font-bold text-[#5442F5]">{{ Auth::user()->email }}</span> telah tersimpan di sistem. <br><br>
            Saat ini status akun Anda adalah <span class="bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded text-xs uppercase tracking-wider">Pending Verification</span>. Anda belum bisa mengakses sistem sebelum divalidasi oleh Super Admin.
        </p>

        <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-left text-xs text-blue-700 font-medium mb-8">
            <strong class="block mb-1 text-blue-800">Langkah Selanjutnya:</strong>
            1. Admin akan memverifikasi kesesuaian NIM dan Email Anda.<br>
            2. Admin akan menentukan hak akses dan penempatan divisi Anda.<br>
            3. Silakan coba login kembali secara berkala.
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-colors">
                Keluar (Logout)
            </button>
        </form>
    </div>
</x-guest-layout>