@extends('layouts.superadmin')
@section('title', 'Pengaturan Profil Akun')

@section('content')
<div class="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-12">

    <!-- Header Profil -->
    <div class="bg-white rounded-[32px] p-6 sm:p-10 shadow-sm border border-slate-100 flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Avatar Besar -->
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-slate-100 flex-shrink-0 border-4 border-white shadow-lg overflow-hidden">
            @php
                $user = auth()->user();
                $foto = $user->avatar ?? $user->photo ?? $user->foto ?? null;
                
                if ($foto) {
                    $fotoUrl = asset('storage/' . $foto);
                } else {
                    $namaUrl = urlencode($user->name ?? 'User');
                    $fotoUrl = "https://ui-avatars.com/api/?name={$namaUrl}&background=5442F5&color=fff&size=200";
                }
            @endphp
            <img src="{{ $fotoUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
        </div>
        
        <!-- Info Dasar -->
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">{{ auth()->user()->name }}</h1>
            <p class="text-sm font-medium text-slate-500 mt-1 mb-3">{{ auth()->user()->email }}</p>
            <span class="px-4 py-1.5 bg-indigo-50 text-[#5442F5] text-xs font-bold rounded-full uppercase tracking-wider">
                Pengurus HIMA
            </span>
        </div>
    </div>

    <!-- Container 2 Kolom -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Kiri: Form Update Profil & Password -->
        <div class="w-full lg:w-2/3 flex flex-col gap-8">
            
            <!-- 1. FORM UPDATE INFORMASI PROFIL -->
            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h2 class="text-xl font-extrabold text-slate-800">Informasi Pribadi</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Perbarui nama lengkap dan alamat email akun Anda.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required autofocus 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="px-8 py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-2xl transition-all shadow-md active:scale-95">
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersimpan!
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 1.5. FORM UPDATE DATA REKAM JEJAK / BUKU INDUK -->
            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h2 class="text-xl font-extrabold text-slate-800">Rekam Jejak & Keahlian</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Lengkapi data ini untuk ditampilkan di Buku Induk HIMA.</p>
                </div>

                @php
                    $userId = auth()->id();
                    $mData = \Illuminate\Support\Facades\DB::table('members')->where('user_id', $userId)->first();
                    
                    $valNim = $mData->nim ?? auth()->user()->nim ?? '';
                    $valContact = $mData->emergency_contact ?? '';
                    
                    $valSkills = '';
                    $valAch = '';

                    if ($mData) {
                        if ($mData->skills) {
                            $decodedSkills = json_decode($mData->skills, true);
                            if (is_array($decodedSkills)) {
                                $valSkills = implode(', ', $decodedSkills);
                            } else {
                                $valSkills = $mData->skills;
                            }
                        }

                        if ($mData->achievements) {
                            $decodedAch = json_decode($mData->achievements, true);
                            if (is_array($decodedAch)) {
                                $achNames = array_column($decodedAch, 'nama');
                                $valAch = implode(', ', $achNames);
                            } else {
                                $valAch = $mData->achievements;
                            }
                        }
                    }
                @endphp

                <form method="post" action="{{ route('profile.update.member') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Profil (Opsional)</label>
                        <input id="photo" name="photo" type="file" accept="image/*"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-[#5442F5]/10 file:text-[#5442F5] hover:file:bg-[#5442F5]/20">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.</p>
                        @error('photo') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nim" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Induk Mahasiswa (NIM)</label>
                            <input id="nim" name="nim" type="text" value="{{ $valNim }}" placeholder="Contoh: 20240001" 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        </div>

                        <div>
                            <label for="emergency_contact" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kontak Darurat (WA)</label>
                            <input id="emergency_contact" name="emergency_contact" type="text" value="{{ $valContact }}" placeholder="Contoh: 081234567890 (Ibu)" 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="skills" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keahlian (Skills)</label>
                        <textarea id="skills" name="skills" rows="3" placeholder="Contoh: Pemrograman Web, Desain Grafis, Public Speaking..." 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none resize-none">{{ $valSkills }}</textarea>
                    </div>

                    <div>
                        <label for="achievements" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Prestasi & Sertifikasi</label>
                        <textarea id="achievements" name="achievements" rows="3" placeholder="Contoh: Juara 1 Web Design Nasional 2025..." 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none resize-none">{{ $valAch }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="px-8 py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-bold rounded-2xl transition-all shadow-md active:scale-95">
                            Simpan Rekam Jejak
                        </button>
                        
                        @if (session('status') === 'member-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersimpan!
                            </p>
                        @endif

                        @if (session('error'))
                            <p class="text-sm font-bold text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                {{ session('error') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 2. FORM UBAH PASSWORD -->
            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h2 class="text-xl font-extrabold text-slate-800">Keamanan Sandi</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Ganti password Anda secara berkala agar akun tetap aman.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sandi Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        @error('current_password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sandi Baru</label>
                        <input id="password" name="password" type="password" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        @error('password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ulangi Sandi Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-[#5442F5]/10 focus:border-[#5442F5] transition-all outline-none">
                        @error('password_confirmation') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-2xl transition-all shadow-md active:scale-95">
                            Perbarui Sandi
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sandi Berhasil Diubah!
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Kanan: Form Danger Zone (Hapus Akun) -->
        <div class="w-full lg:w-1/3">
            <div class="bg-red-50/50 rounded-[32px] p-8 border border-red-100">
                <div class="mb-6 text-center lg:text-left">
                    <div class="w-12 h-12 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center text-xl mb-4 mx-auto lg:mx-0">⚠️</div>
                    <h2 class="text-xl font-extrabold text-red-700">Zona Berbahaya</h2>
                    <p class="text-sm text-red-500/80 font-medium mt-2 leading-relaxed">
                        Jika Anda menghapus akun, semua sumber daya dan data Anda akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="w-full px-6 py-3.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-2xl transition-all shadow-md shadow-red-500/20 active:scale-95">
                    Hapus Akun Permanen
                </button>

                <x-modal name="confirm-user-deletion" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                        @csrf
                        @method('delete')

                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Apakah Anda yakin?</h2>
                        <p class="mt-2 text-sm text-slate-500 font-medium leading-relaxed">
                            Setelah akun dihapus, semua data akan hilang secara permanen. Masukkan kata sandi Anda untuk konfirmasi.
                        </p>

                        <div class="mt-6">
                            <label for="password_delete" class="sr-only">Password</label>
                            <input id="password_delete" name="password" type="password" placeholder="Sandi Anda saat ini" required
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none">
                            @error('password', 'userDeletion') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl transition-all shadow-md">
                                Ya, Hapus Akun
                            </button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>

    </div>
</div>
@endsection