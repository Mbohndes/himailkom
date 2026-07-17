<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\AgendaAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with(['pic', 'period'])->latest();

        // Fitur Filter by Category & Period
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $agendas = $query->paginate(10);
        return view('superadmin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk aksi ini.');
        }

        $periods = DB::table('periods')->get();
        $users = User::orderBy('name', 'asc')->get();
        
        return view('superadmin.agendas.form', compact('periods', 'users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk aksi ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Rapat,Musyawarah,Evaluasi,Lainnya',
            'date_time' => 'required|date',
            'location' => 'required|string',
            'pic_id' => 'required|exists:users,id',
            'period_id' => 'required|exists:periods,id',
            'participants' => 'required|array', // Array ID anggota yang diundang
        ]);

        $agenda = Agenda::create($request->except('participants'));

        // Otomatis buat daftar absen (Belum Absen) untuk peserta yang dipilih
        foreach ($request->participants as $userId) {
            AgendaAttendance::create([
                'agenda_id' => $agenda->id,
                'user_id' => $userId,
                'status' => 'Belum Absen'
            ]);
        }

        return redirect()->route('superadmin.agendas.index')->with('success', 'Agenda berhasil dijadwalkan!');
    }

    // Detail Agenda sekaligus Halaman Absensi
    public function show(Agenda $agenda)
    {
        $agenda->load(['pic', 'attendances.user']);
        
        // Kalkulasi Rekap
        $rekap = [
            'Hadir' => $agenda->attendances->where('status', 'Hadir')->count(),
            'Izin' => $agenda->attendances->where('status', 'Izin')->count(),
            'Sakit' => $agenda->attendances->where('status', 'Sakit')->count(),
            'Alfa' => $agenda->attendances->where('status', 'Alfa')->count(),
            'Belum Absen' => $agenda->attendances->where('status', 'Belum Absen')->count(),
        ];

        return view('superadmin.agendas.show', compact('agenda', 'rekap'));
    }

    public function updateAttendance(Request $request, Agenda $agenda)
    {
        $request->validate([
            'attendance_id' => 'required|exists:agenda_attendances,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alfa,Belum Absen'
        ]);

        $attendance = AgendaAttendance::find($request->attendance_id);
        $attendance->update([
            'status' => $request->status,
            'reason' => $request->reason ?? null
        ]);

        return redirect()->back()->with('success', 'Status kehadiran diperbarui!');
    }
    
    // Fitur destroy opsional (Bisa ditambahkan kemudian jika diperlukan)
    public function destroy(Agenda $agenda)
    {
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk aksi ini.');
        }

        $agenda->delete();
        return redirect()->route('superadmin.agendas.index')->with('success', 'Agenda dihapus.');
    }

    // HALAMAN FORM EDIT
    public function edit(Agenda $agenda)
    {
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk aksi ini.');
        }

        $periods = DB::table('periods')->get();
        $users = User::orderBy('name', 'asc')->get();
        
        return view('superadmin.agendas.form', compact('agenda', 'periods', 'users'));
    }

    // PROSES SIMPAN EDIT
    public function update(Request $request, Agenda $agenda)
    {
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengubah data kehadiran.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Rapat,Musyawarah,Evaluasi,Lainnya',
            'date_time' => 'required|date',
            'location' => 'required|string',
            'pic_id' => 'required|exists:users,id',
            'period_id' => 'required|exists:periods,id',
        ]);

        $agenda->update($request->except('participants'));

        return redirect()->route('superadmin.agendas.index')->with('success', 'Agenda berhasil diperbarui!');
    }
}
