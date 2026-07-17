<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // ==========================================
        // 1. DATA EMAS BARIS UTAMA (TOP CARDS)
        // ==========================================
        $totalAnggota = DB::table('users')->where('id', '!=', 1)->where('status', 'Aktif')->count();
        
        // [PERBAIKAN]: Tambahkan whereNull('deleted_at') agar data terhapus tidak dihitung
        $totalProker = DB::table('prokers')->whereNull('deleted_at')->count();
        $totalArsip = DB::table('archives')->count();
        
        // Perhitungan Saldo Global
        $totalIuranLunas = DB::table('due_payments')->where('status', 'Lunas')->sum('amount_paid') ?? 0;
        $totalPemasukanUmum = DB::table('incomes')->sum('amount') ?? 0;
        $totalPengeluaranGlobal = DB::table('expenses')->sum('amount') ?? 0;
        $saldoGlobal = ($totalIuranLunas + $totalPemasukanUmum) - $totalPengeluaranGlobal;

        // ==========================================
        // 2. LOGIKA PUSAT TINDAKAN (ACTION CENTER)
        // ==========================================
        $pendingVerifikasi = DB::table('users')->where('status', 'Pending')->count();
        
        $pendingProposal = 0; 
        $pendingLpj = 0; 
        
        $tunggakanIuranCount = DB::table('due_payments')->where('status', '!=', 'Lunas')->count();

        // ==========================================
        // 3. AGREGASI DETAIL BULANAN & PROGRES
        // ==========================================
        $pemasukanBulanIni = DB::table('incomes')->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount') ?? 0;
        $pengeluaranBulanIni = DB::table('expenses')->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount') ?? 0;
        
        $prokerSelesai = DB::table('prokers')->whereNull('deleted_at')->where('status', 'Selesai')->count();
        $prokerBerjalan = DB::table('prokers')->whereNull('deleted_at')->where('status', 'Berjalan')->count();
        $prokerBelumMulai = DB::table('prokers')->whereNull('deleted_at')->where('status', 'Belum Mulai')->count();
        $prokerTerlambat = DB::table('prokers')->whereNull('deleted_at')->where('status', 'Terlambat')->count();

        // --- [BARU] LOGIKA FILTER DROPDOWN IURAN ---
        // 1. Ambil semua data nama tagihan (Master Dues) untuk diisi ke dropdown
        $masterTagihan = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('dues')) {
            $masterTagihan = DB::table('dues')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        }

        // 2. Tangkap id tagihan yang dipilih user dari URL (contoh: ?tagihan_id=5)
        $selectedTagihan = request('tagihan_id');
        
        // 3. Hitung Iuran (Terapkan filter jika ada yang dipilih)
        $queryIuran = DB::table('due_payments');
        if ($selectedTagihan && $selectedTagihan != 'semua') {
            $queryIuran->where('due_id', $selectedTagihan); // Pastikan foreign key-nya 'due_id'
        }

        $iuranLunasCount = (clone $queryIuran)->where('status', 'Lunas')->count();
        $iuranBelumBayarCount = (clone $queryIuran)->where('status', '!=', 'Lunas')->count();

        // ==========================================
        // 4. AGENDA HARI INI (ANTI-ERROR SYSTEM)
        // ==========================================
        $agendaHariIni = collect(); 
        
        if (\Illuminate\Support\Facades\Schema::hasTable('agendas')) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'date_time')) {
                // [PERBAIKAN]: Tambahkan whereNull('deleted_at')
                $agendaHariIni = DB::table('agendas')->whereNull('deleted_at')->whereDate('date_time', $today)->get();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'date')) {
                $agendaHariIni = DB::table('agendas')->whereNull('deleted_at')->whereDate('date', $today)->get();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'tanggal')) {
                $agendaHariIni = DB::table('agendas')->whereNull('deleted_at')->whereDate('tanggal', $today)->get();
            }
        }
        
        $recentActivities = DB::table('prokers')
                            ->whereNull('deleted_at')
                            ->selectRaw("'Pengurus' as user_name, name as proker_name, created_at as time")
                            ->orderBy('created_at', 'desc')
                            ->limit(4)
                            ->get();

        $upcomingProkers = DB::table('prokers')->whereNull('deleted_at')->orderBy('id', 'desc')->limit(4)->get();

        // ==========================================
        // 5. TAMBAHAN KHUSUS SESI 1
        // ==========================================
        $activePeriod = DB::table('periods')->orderBy('id', 'desc')->value('name') ?? $currentYear;
        
        $agendaBulanIni = 0;
        if (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'date_time')) {
            // [PERBAIKAN]: Tambahkan whereNull('deleted_at')
            $agendaBulanIni = DB::table('agendas')->whereNull('deleted_at')->whereMonth('date_time', $currentMonth)->whereYear('date_time', $currentYear)->count();
        }

        $totalPending = $pendingVerifikasi;

        // ==========================================
        // 6. [SESI 3] KALENDER & DAFTAR AGENDA BULANAN
        // ==========================================
        
        // A. Filter Daftar Agenda (Kolom Kiri)
        $selectedBulanAgenda = request('bulan_agenda', $currentMonth); // Default bulan ini
        
        $agendaFiltered = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('agendas')) {
            $queryAgenda = DB::table('agendas')->whereNull('deleted_at');
            
            if (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'date_time')) {
                $agendaFiltered = $queryAgenda->whereMonth('date_time', $selectedBulanAgenda)->whereYear('date_time', $currentYear)->orderBy('date_time', 'asc')->get();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('agendas', 'date')) {
                $agendaFiltered = $queryAgenda->whereMonth('date', $selectedBulanAgenda)->whereYear('date', $currentYear)->orderBy('date', 'asc')->get();
            }
        }

        // B. Data Pin Kalender (Kolom Kanan)
        $kalenderData = [];
        
        // Tarik Data Agenda (Pin Hijau)
        if (\Illuminate\Support\Facades\Schema::hasTable('agendas')) {
            $allAgendas = DB::table('agendas')->whereNull('deleted_at')->get();
            foreach($allAgendas as $agenda) {
                $kalenderData[] = [
                    'title' => '📅 ' . $agenda->title,
                    'start' => Carbon::parse($agenda->date_time ?? $agenda->date ?? $agenda->created_at)->format('Y-m-d'),
                    'color' => '#14C95A' // Hijau
                ];
            }
        }
        
        // Tarik Data Proker (Pin Ungu)
        if (\Illuminate\Support\Facades\Schema::hasTable('prokers')) {
            $allProkers = DB::table('prokers')->whereNull('deleted_at')->get();
            foreach($allProkers as $proker) {
                
                // Sistem deteksi otomatis nama kolom tanggal pelaksanaan proker Anda
                $tanggalPelaksanaan = $proker->start_date ?? $proker->tanggal_mulai ?? $proker->date ?? $proker->tanggal ?? $proker->waktu_pelaksanaan ?? $proker->created_at;

                $kalenderData[] = [
                    'title' => '📁 ' . ($proker->name ?? $proker->title ?? 'Proker'),
                    'start' => \Carbon\Carbon::parse($tanggalPelaksanaan)->format('Y-m-d'),
                    'color' => '#5442F5' // Ungu
                ];
            }
        }

        // ==========================================
        // 7. [SESI 4] ANALITIK BERITA & BERITA TERBARU
        // ==========================================
        $totalBerita = 0;
        $beritaPublished = 0;
        $beritaDraft = 0;
        $beritaTerbaru = collect();

        if (\Illuminate\Support\Facades\Schema::hasTable('news')) {
            // Hitung total seluruh artikel berita
            $totalBerita = DB::table('news')->whereNull('deleted_at')->count();

            // Hitung sebaran status (kondisional jika ada kolom status)
            if (\Illuminate\Support\Facades\Schema::hasColumn('news', 'status')) {
                $beritaPublished = DB::table('news')->whereNull('deleted_at')->where('status', 'Published')->count();
                $beritaDraft = DB::table('news')->whereNull('deleted_at')->where('status', 'Draft')->count();
            } else {
                $beritaPublished = $totalBerita; // Fallback aman
            }

            // Ambil 3 berita terbaru beserta thumbnail, judul, dan konten
            $beritaTerbaru = DB::table('news')
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->limit(3)
                ->get();
        }

        return view('superadmin.dashboard', compact(
            'totalAnggota', 'totalProker', 'totalArsip', 'saldoGlobal',
            'pendingVerifikasi', 'pendingProposal', 'pendingLpj', 'tunggakanIuranCount',
            'pemasukanBulanIni', 'pengeluaranBulanIni',
            'prokerSelesai', 'prokerBerjalan', 'prokerBelumMulai', 'prokerTerlambat',
            'iuranLunasCount', 'iuranBelumBayarCount',
            'agendaHariIni', 'recentActivities', 'upcomingProkers',
            'activePeriod', 'agendaBulanIni', 'totalPending', // <-- Nah, koma ini yang tadi tertinggal!
            'masterTagihan', 'selectedTagihan',
            'selectedBulanAgenda', 'agendaFiltered', 'kalenderData',
            'totalBerita', 'beritaPublished', 'beritaDraft', 'beritaTerbaru'
        ));
    }
}