<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Proker;
use App\Models\Division;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SuperAdmin\ProkerRequest;
use App\Models\ActivityLog;

class ProkerController extends Controller
{
    /**
     * Menampilkan statistik finansial, grafik, dan kalender program kerja.
     */
    public function dashboard()
    {
        // Statistik Status Proker
        $totalProker = Proker::count();
        $prokerBerjalan = Proker::where('status', 'Berjalan')->count();
        $prokerSelesai = Proker::where('status', 'Selesai')->count();
        $prokerTerlambat = Proker::where('status', 'Terlambat')->count();
        $prokerDibatalkan = Proker::where('status', 'Dibatalkan')->count();

        // Statistik Finansial & Progress
        $totalAnggaran = Proker::sum('budget_planned');
        $totalRealisasi = Proker::sum('budget_realized');
        
        // Menghindari pembagian dengan nol
        $persentasePenyelesaian = $totalProker > 0 
            ? round(Proker::avg('progress_percentage'), 2) 
            : 0;

        // Menghitung persentase penyerapan anggaran dengan batas maksimal 100%
        $persentasePenyerapan = $totalAnggaran > 0 
            ? min(100, round(($totalRealisasi / $totalAnggaran) * 100, 1)) 
            : 0;

        // Data untuk Grafik (Chart.js)
        $chartData = [
            'Berjalan' => $prokerBerjalan,
            'Selesai' => $prokerSelesai,
            'Terlambat' => $prokerTerlambat,
            'Dibatalkan' => $prokerDibatalkan,
        ];

        // Data untuk Kalender (FullCalendar)
        // Kita petakan warnanya berdasarkan status
        $calendarEvents = Proker::select('name as title', 'start_date as start', 'end_date as end', 'status')
            ->get()
            ->map(function ($proker) {
                // Modifikasi tanggal end ditambah 1 hari agar FullCalendar merender full-day event dengan benar
                $proker->end = \Carbon\Carbon::parse($proker->end)->addDay()->format('Y-m-d');
                
                // Menentukan warna kalender berdasarkan status
                $proker->color = match($proker->status) {
                    'Selesai' => '#14C95A', // Emerald
                    'Berjalan' => '#5442F5', // Indigo
                    'Terlambat' => '#F59E0B', // Amber
                    'Dibatalkan' => '#EF4444', // Red
                    default => '#94A3B8', // Slate (Draft)
                };
                return $proker;
            });

        return view('superadmin.prokers.dashboard', compact(
            'totalProker', 'prokerBerjalan', 'prokerSelesai', 'prokerTerlambat', 'prokerDibatalkan',
            'totalAnggaran', 'totalRealisasi', 'persentasePenyelesaian', 'persentasePenyerapan',
            'chartData', 'calendarEvents'
        ));
    }

    /**
     * Menampilkan daftar program kerja.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Proker::with(['division', 'period', 'pic']);

        // [PENAMBAHAN ROLE & PERMISSION] - TEMPAT PRIBADI KADIV
        if ($user->hasRole('Kepala Divisi')) {
            // Deteksi ID Divisi dari tabel members berdasarkan login user
            $member = DB::table('members')->where('user_id', $user->id)->first();
            $divisi_id = $member->division_id ?? $member->divisi_id ?? null;
            
            if ($divisi_id) {
                // Filter murni hanya proker divisinya
                $query->where('division_id', $divisi_id)->orWhere('divisi_id', $divisi_id);
            }
        }

        $prokers = $query->latest()->paginate(10);
        return view('superadmin.prokers.index', compact('prokers'));
    }

    /**
     * Menampilkan form untuk membuat program kerja baru.
     */
    public function create()
    {
        // Blokir Akses Anggota
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anggota tidak dapat membuat Proker.');
        }

        $divisions = Division::where('status', 'Aktif')->get();
        $periods = DB::table('periods')->get(); 
        $users = User::all();

        return view('superadmin.prokers.form', compact('divisions', 'periods', 'users'));
    }

    /**
     * Menyimpan data program kerja baru ke database.
     */
    public function store(ProkerRequest $request)
    {
        Proker::create($request->validated());

        ActivityLog::catat('Program Kerja', 'CREATE', "Menambahkan proker baru: {$request->nama_proker}");
        
        return redirect()->route('superadmin.prokers.index')
                         ->with('success', 'Program Kerja berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk program kerja tertentu.
     */
    public function edit(Proker $proker)
    {
        // Blokir Akses Anggota
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Hanya pengurus Inti yang dapat mengubah Proker.');
        }

        $divisions = Division::where('status', 'Aktif')->get();
        $periods = DB::table('periods')->get();
        $users = User::all();

        return view('superadmin.prokers.form', compact('proker', 'divisions', 'periods', 'users'));
    }

    /**
     * Memperbarui data program kerja tertentu di database.
     */
    public function update(ProkerRequest $request, Proker $proker)
    {
        $proker->update($request->validated());

        return redirect()->route('superadmin.prokers.index')
                         ->with('success', 'Data Program Kerja berhasil diperbarui!');
    }

    /**
     * Menghapus program kerja tertentu (Soft Delete).
     */
    public function destroy(Proker $proker)
    {
        $proker->delete();

        return redirect()->route('superadmin.prokers.index')
                         ->with('success', 'Program Kerja berhasil dihapus!');
    }
}
