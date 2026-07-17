<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MemberApplication;
use App\Models\User;
use App\Models\Division;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberApplication::latest();

        // Fitur Pencarian Berdasarkan Nama/NIM
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status Progres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(10)->appends($request->all());
        
        // Mengambil data pendukung untuk modal aksi penempatan admin
        $divisions = Division::orderBy('name', 'asc')->get();
        $periods = Period::orderBy('name', 'desc')->get();

        return view('superadmin.membership.applications', compact('applications', 'divisions', 'periods'));
    }

    public function processAction(Request $request, MemberApplication $application)
    {
        $request->validate([
            'action_type' => 'required|in:Terima,Tolak,Revisi',
            'admin_notes' => 'nullable|string',
            'division_id' => 'required_if:action_type,Terima',
            'period_id' => 'required_if:action_type,Terima',
            'assigned_role' => 'required_if:action_type,Terima'
        ]);

        DB::beginTransaction();
        try {
            if ($request->action_type === 'Terima') {
                // 1. Update Status Progres Aplikasi
                $application->update([
                    'status' => 'Disetujui',
                    'division_id' => $request->division_id,
                    'period_id' => $request->period_id,
                    'assigned_role' => $request->assigned_role,
                    'admin_notes' => 'Pendaftaran disetujui oleh admin.'
                ]);

                // 2. OTOMATISASI AKUN AKTIF & ANGGOTA AKTIF (Membuat entri di tabel Users)
                // Password bawaan menggunakan NIM mahasiswa agar mereka bisa login awal
                $user = User::create([
                    'name' => $application->name,
                    'nim' => $application->nim,
                    'email' => $application->email,
                    'password' => bcrypt($application->nim), 
                    'division_id' => $request->division_id,
                    'period_id' => $request->period_id,
                ]);

                // Menentukan Peran Spatie secara otomatis sesuai input admin
                $user->assignRole($request->assigned_role);

            } elseif ($request->action_type === 'Tolak') {
                $application->update([
                    'status' => 'Ditolak',
                    'admin_notes' => $request->admin_notes ?? 'Maaf, pendaftaran Anda ditolak.'
                ]);
            } else {
                $application->update([
                    'status' => 'Perlu Revisi Data',
                    'admin_notes' => $request->admin_notes ?? 'Mohon periksa kembali keselarasan data Anda.'
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Aksi status pendaftaran berhasil diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses aksi keanggotaan.');
        }
    }
}