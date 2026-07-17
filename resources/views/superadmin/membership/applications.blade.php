@extends('layouts.superadmin')
@section('title', 'Pendaftaran Mahasiswa')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10" x-data="{ modalOpen: false, currentApp: {}, actionUrl: '' }">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Pendaftaran Mahasiswa</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Validasi data pengajuan calon anggota baru dan tentukan penempatan divisi organisasi.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.membership.applications.index') }}" method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa atau NIM..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
        
        <select name="status" class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-52">
            <option value="">Semua Status Progres</option>
            <option value="Terdaftar" {{ request('status') == 'Terdaftar' ? 'selected' : '' }}>Terdaftar / Menunggu</option>
            <option value="Perlu Revisi Data" {{ request('status') == 'Perlu Revisi Data' ? 'selected' : '' }}>Perlu Revisi Data</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui (Akun Aktif)</option>
        </select>
        
        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">Saring</button>
    </form>

    <div class="bg-white rounded-[30px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE]/60 text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-slate-100">
                        <th class="px-6 py-4">Mahasiswa & NIM</th>
                        <th class="px-6 py-4">Kontak Kampus</th>
                        <th class="px-6 py-4">Prodi & Angkatan</th>
                        <th class="px-6 py-4">Tanggal Daftar</th>
                        <th class="px-6 py-4">Status Progres</th>
                        <th class="px-6 py-4 text-right">Kendali Admin</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                    @forelse($applications as $app)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-sm">{{ $app->name }}</div>
                            <div class="text-xs text-slate-400 font-medium mt-0.5">NIM: {{ $app->nim }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-700">{{ $app->email }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $app->phone }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium">
                            <div>{{ $app->study_program }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">Angkatan {{ $app->cohort }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-500">
                            {{ $app->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($app->status === 'Terdaftar' || $app->status === 'Menunggu Verifikasi')
                                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-100">Menunggu Verifikasi</span>
                            @elseif($app->status === 'Disetujui')
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-2.5 py-1 rounded-md border border-emerald-100">Disetujui (Akun Aktif)</span>
                            @elseif($app->status === 'Perlu Revisi Data')
                                <span class="bg-amber-50 text-amber-600 text-xs font-bold px-2.5 py-1 rounded-md border border-amber-100">Perlu Revisi</span>
                            @else
                                <span class="bg-red-50 text-red-600 text-xs font-bold px-2.5 py-1 rounded-md border border-red-100">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" @click="modalOpen = true; currentApp = {{ json_encode($app) }}; actionUrl = '{{ route('superadmin.membership.applications.action', $app->id) }}'" class="px-4 py-1.5 bg-[#5442F5] hover:bg-[#4331e5] text-white font-bold text-xs rounded-xl shadow-xs transition-all">
                                Kelola Aksi
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada mahasiswa yang masuk dalam antrean pendaftaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/30">{{ $applications->links() }}</div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" x-cloak>
        <div class="bg-white rounded-[30px] p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto" @click.away="modalOpen = false">
            
            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-800 text-lg">Validasi Keanggotaan</h3>
                <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>

            <div class="bg-[#F4F7FE] p-3 rounded-2xl text-xs font-medium text-slate-600 space-y-1">
                <div><span class="font-bold text-slate-400">Nama:</span> <span x-text="currentApp.name" class="text-slate-800 font-bold"></span></div>
                <div><span class="font-bold text-slate-400">NIM / Email:</span> <span x-text="currentApp.nim"></span> / <span x-text="currentApp.email"></span></div>
            </div>

            <form :action="actionUrl" method="POST" class="space-y-4" x-data="{ choice: 'Terima' }">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tentukan Keputusan</label>
                    <select name="action_type" x-model="choice" class="w-full bg-[#F4F7FE] border-none text-sm font-bold text-slate-700 rounded-xl px-4 py-2.5">
                        <option value="Terma">Terima (Disetujui & Tempatkan)</option>
                        <option value="Revisi">Minta Perlu Revisi Data</option>
                        <option value="Tolak">Tolak Pendaftaran</option>
                    </select>
                </div>

                <div x-show="choice === 'Terima'" class="space-y-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tempatkan ke Divisi</label>
                        <select name="division_id" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tentukan Periode Jabatan</label>
                        <select name="period_id" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                            @foreach($periods as $per)
                                <option value="{{ $per->id }}">{{ $per->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tentukan Peran (Role)</label>
                        <select name="assigned_role" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                            <option value="Pengurus">Pengurus HIMA</option>
                            <option value="Anggota">Anggota Biasa</option>
                        </select>
                    </div>
                </div>

                <div x-show="choice !== 'Terima'">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Beri Catatan Alasan / Instruksi Revisi</label>
                    <textarea name="admin_notes" rows="3" placeholder="Contoh: Format NIM salah atau mohon ganti foto..." class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white text-sm font-extrabold rounded-xl shadow-md transition-colors">
                    Sahkan Keputusan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection