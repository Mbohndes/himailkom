<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\Period;
use App\Models\DuePayment;
use App\Models\Archive;
// (Jika ada model Proker dan Agenda, bisa di-import juga nanti)

class ReportController extends Controller
{
    // 1. DASHBOARD LAPORAN (Ringkasan Semua Modul)
    public function index()
    {
        $totalAnggota = User::where('id', '!=', 1)->count();
        $totalAlumni = User::where('status', 'Nonaktif')->count();
        $totalKas = DuePayment::where('status', 'Lunas')->sum('amount_paid');
        $totalArsip = Archive::count();

        return view('superadmin.reports.index', compact('totalAnggota', 'totalAlumni', 'totalKas', 'totalArsip'));
    }

    // 2. LAPORAN ANGGOTA (Dengan Filter Global)
    public function members(Request $request)
    {
        $query = User::with(['division', 'period', 'profile'])->where('id', '!=', 1);

        // -- FILTERING GLOBAL --
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->filled('status')) {
            // Aktif / Nonaktif (Alumni) / Pengurus
            if ($request->status === 'Pengurus') {
                $query->role('Pengurus'); // Memanfaatkan Spatie Permission
            } else {
                $query->where('status', $request->status);
            }
        }
        if ($request->filled('cohort')) {
            // Filter angkatan menggunakan relasi ke profile
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('entry_year', $request->cohort);
            });
        }

        $members = $query->get(); // Gunakan get() bukan paginate() agar bisa dicetak semua datanya
        
        $periods = Period::orderBy('start_year', 'desc')->get();
        $divisions = Division::orderBy('name', 'asc')->get();

        // Logika Mode Cetak (Print)
        if ($request->export === 'print') {
            return view('superadmin.reports.print_members', compact('members', 'request'));
        }
        

        return view('superadmin.reports.members', compact('members', 'periods', 'divisions'));
    }

    // 3. LAPORAN PROGRAM KERJA
    public function workPrograms(Request $request)
    {
        // GANTI WorkProgram menjadi Proker
        $query = \App\Models\Proker::with(['division', 'period']);

        // -- FILTERING GLOBAL --
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $programs = $query->get();
        
        $periods = Period::orderBy('name', 'desc')->get();
        $divisions = Division::orderBy('name', 'asc')->get();

        if ($request->export === 'print') {
            return view('superadmin.reports.print_programs', compact('programs', 'request'));
        }

        return view('superadmin.reports.programs', compact('programs', 'periods', 'divisions'));
    }

    // 4. LAPORAN KEUANGAN (KAS & IURAN)
    public function finance(Request $request)
    {
        // Tarik data pembayaran yang sudah BERSTATUS LUNAS (Kas Masuk Resmi)
        $query = \App\Models\DuePayment::with(['due.period', 'user'])->where('status', 'Lunas');

        // -- FILTER DENGAN PARAMETER GLOBAL --
        if ($request->filled('period_id')) {
            $query->whereHas('due', function($q) use ($request) {
                $q->where('period_id', $request->period_id);
            });
        }
        if ($request->filled('month')) {
            $query->whereMonth('paid_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('paid_at', $request->year);
        }

        $payments = $query->latest('paid_at')->get();

        // Hitung Total Kas Masuk & Saldo berdasarkan hasil filter
        $totalMasuk = $payments->sum('amount_paid');
        $totalKeluar = 0; // Placeholder: Dapat dikoneksikan jika Anda membuat tabel Kas Keluar nantinya
        $saldoAkhir = $totalMasuk - $totalKeluar;

        // Data pendukung komponen filter dropdown
        $periods = Period::orderBy('name', 'desc')->get();
        
        // Ambil daftar tahun secara dinamis dari data transaksi yang ada
        $years = \App\Models\DuePayment::where('status', 'Lunas')
                    ->whereNotNull('paid_at')
                    ->selectRaw('YEAR(paid_at) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

        // Logika Mode Cetak Dokumen / Print-to-PDF
        if ($request->export === 'print') {
            return view('superadmin.reports.print_finance', compact('payments', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'request'));
        }

        return view('superadmin.reports.finance', compact('payments', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'periods', 'years'));
    }

    public function activity()
    {
        $users = \App\Models\User::where('id', '!=', 1)->get();
        $reportData = collect();

        // 1. [SISTEM DETEKSI OTOMATIS NAMA TABEL ABSENSI]
        // Kode ini akan mengintip Model Agenda Anda untuk mengetahui nama tabel aslinya
        $tabelAbsen = 'attendances'; 
        try {
            if (class_exists('\App\Models\Agenda')) {
                $agenda = new \App\Models\Agenda();
                if (method_exists($agenda, 'attendances')) {
                    $relasi = $agenda->attendances();
                    $tabelAbsen = $relasi instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany 
                        ? $relasi->getTable() 
                        : $relasi->getModel()->getTable();
                }
            }
        } catch (\Exception $e) {}

        foreach($users as $user) {
            $hadirCount = 0;
            $totalAgendaUser = 0;

            try {
                // 2. Tarik data kehadiran menggunakan nama tabel asli yang sudah dideteksi
                $hadirCount = \Illuminate\Support\Facades\DB::table($tabelAbsen)
                                ->where('user_id', $user->id)
                                ->where('status', 'LIKE', '%Hadir%')
                                ->count();
                
                // Hitung seberapa sering anggota ini diundang ke agenda
                $totalAgendaUser = \Illuminate\Support\Facades\DB::table($tabelAbsen)
                                ->where('user_id', $user->id)
                                ->count();
            } catch (\Exception $e) {
                // Bypass jika terjadi error koneksi tabel
            }

            // 3. Fallback jika anggota ini belum pernah diundang ke agenda apapun
            if ($totalAgendaUser == 0) {
                 try {
                     $totalAgendaUser = \Illuminate\Support\Facades\DB::table('agendas')->whereNull('deleted_at')->count();
                 } catch (\Exception $e) {
                     $totalAgendaUser = 0;
                 }
            }

            // 4. Kalkulasi Persentase
            $persentase = $totalAgendaUser > 0 ? round(($hadirCount / $totalAgendaUser) * 100) : 0;

            // 5. Penentuan Label Warna
            if($persentase >= 80) {
                $keterangan = 'Sangat Aktif'; 
                $warna = 'text-emerald-700 bg-emerald-100 border-emerald-200';
            } elseif($persentase >= 50) {
                $keterangan = 'Cukup Aktif'; 
                $warna = 'text-blue-700 bg-blue-100 border-blue-200';
            } elseif($persentase >= 20) {
                $keterangan = 'Kurang Aktif'; 
                $warna = 'text-amber-700 bg-amber-100 border-amber-200';
            } else {
                $keterangan = 'Pasif'; 
                $warna = 'text-red-700 bg-red-100 border-red-200';
            }

            $reportData->push((object)[
                'name' => $user->name,
                'role' => method_exists($user, 'getRoleNames') ? ($user->getRoleNames()->first() ?? 'Anggota') : 'Anggota',
                'total_hadir' => $hadirCount,
                'total_agenda' => $totalAgendaUser,
                'persentase' => $persentase,
                'keterangan' => $keterangan,
                'warna' => $warna
            ]);
        }

        // Urutkan dari yang persentasenya tertinggi (Ranking 1)
        $reportData = $reportData->sortByDesc('persentase')->values();

        return view('superadmin.reports.activity', compact('reportData'));
    }

    
    // (Fungsi Laporan Proker, Keuangan, dsb bisa Anda kembangkan menggunakan pola yang persis sama seperti di atas)
}