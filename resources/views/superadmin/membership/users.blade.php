@extends('layouts.superadmin')
@section('title', 'Manajemen Pengguna Aktif')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10" x-data="{ modalOpen: false, currentUser: {}, updateUrl: '', resetUrl: '' }">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Kelola hak akses (Role), penempatan divisi, status akun, dan reset password anggota.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.membership.users.index') }}" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau NIM..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
        
        <select name="status" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
            <option value="">Semua Status</option>
            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif / Suspend</option>
        </select>
        
        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Cari</button>
    </form>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE]/60 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Profil & Kontak</th>
                        <th class="px-6 py-4">Penempatan (Divisi & Role)</th>
                        <th class="px-6 py-4">Status & Aktivitas</th>
                        <th class="px-6 py-4 text-right">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/40 transition-colors {{ $user->status == 'Nonaktif' ? 'bg-red-50/30' : '' }}">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=F4F7FE&color=5442F5' }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-500 font-medium">{{ $user->email }} | NIM: {{ $user->nim ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $user->position ?? 'Anggota Biasa' }}</div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="bg-indigo-50 text-[#5442F5] text-[10px] font-extrabold px-2 py-0.5 rounded">{{ $user->roles->pluck('name')->first() ?? 'Tidak ada Role' }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $user->division->name ?? 'Lintas Divisi' }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($user->status === 'Aktif')
                                <span class="text-emerald-500 text-xs font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Aktif</span>
                            @else
                                <span class="text-red-500 text-xs font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Nonaktif</span>
                            @endif
                            <div class="text-[10px] text-slate-400 mt-1 font-medium">Login: {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</div>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <button type="button" @click="
                                modalOpen = true; 
                                currentUser = { 
                                    name: '{{ addslashes($user->name) }}', 
                                    division: '{{ $user->division_id }}', 
                                    period: '{{ $user->period_id }}', 
                                    position: '{{ addslashes($user->position) }}', 
                                    status: '{{ $user->status }}', 
                                    role: '{{ $user->roles->pluck('name')->first() }}' 
                                }; 
                                updateUrl = '{{ route('superadmin.membership.users.update', $user->id) }}';
                                resetUrl = '{{ route('superadmin.membership.users.resetPassword', $user->id) }}';
                            " class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl shadow-xs transition-colors">
                                Edit / Kelola
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada data pengguna yang terdaftar di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/30">{{ $users->links() }}</div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" x-cloak>
        <div class="bg-white rounded-[30px] p-6 max-w-2xl w-full shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto" @click.away="modalOpen = false">
            
            <div class="flex justify-between items-center pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg">Kelola Hak Akses Pengguna</h3>
                    <p class="text-xs text-slate-400 font-medium" x-text="currentUser.name"></p>
                </div>
                <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <form :action="updateUrl" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Role (Hak Akses) <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                            <option value="">Pilih Role...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Divisi</label>
                            <select name="division_id" x-model="currentUser.division" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-3 py-2.5">
                                <option value="">Lintas Divisi</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div->id }}">{{ $div->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode</label>
                            <select name="period_id" x-model="currentUser.period" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-3 py-2.5">
                                @foreach($periods as $per)
                                    <option value="{{ $per->id }}">{{ $per->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jabatan (Opsional)</label>
                        <input type="text" name="position" x-model="currentUser.position" placeholder="Contoh: Ketua Divisi Humas" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status Akun</label>
                        <select name="status" x-model="currentUser.status" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500">
                            <option value="Aktif">Aktif (Bisa Login)</option>
                            <option value="Nonaktif">Nonaktif (Suspend/Alumni)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-extrabold rounded-xl shadow-md transition-colors">
                        Simpan Perubahan
                    </button>
                </form>

                <div class="border-t md:border-t-0 md:border-l border-slate-100 md:pl-6 pt-4 md:pt-0 space-y-4 flex flex-col justify-end pb-1">
                    <div class="bg-red-50 rounded-2xl p-4 border border-red-100 text-center">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-500 mx-auto mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="font-bold text-red-600 text-sm mb-1">Reset Password Akun</h4>
                        <p class="text-[11px] text-red-500/80 mb-4 leading-relaxed">
                            Lupa sandi? Aksi ini akan mengatur ulang password pengguna menjadi <strong>sama persis dengan Nomor Induk Mahasiswa (NIM)</strong> mereka.
                        </p>
                        <form :action="resetUrl" method="POST" onsubmit="return confirm('Yakin ingin mereset password akun ini ke NIM awal?');">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                                Reset ke Default (NIM)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection