<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberDataController extends Controller
{
    // Menampilkan Tabel Database Semua Anggota & Alumni
    public function index(Request $request)
    {
        $query = User::with(['division', 'period', 'profile'])->where('id', '!=', 1);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        $members = $query->paginate(15)->appends($request->all());

        return view('superadmin.membership.data_index', compact('members'));
    }

    // Menampilkan Buku Induk / CV Lengkap Anggota
    public function show($id)
    {
        $member = User::with(['division', 'period', 'profile'])->findOrFail($id);
        
        // Auto-create profil kosong jika belum ada (agar tidak error saat di-view)
        if (!$member->profile) {
            $member->profile()->create([]);
            $member->load('profile'); // Muat ulang relasi
        }

        return view('superadmin.membership.data_show', compact('member'));
    }

    // Menampilkan Direktori Alumni
    public function alumni(Request $request)
    {
        // Kita asumsikan alumni adalah user yang statusnya 'Nonaktif' dan memiliki tahun lulus
        $query = User::with(['division', 'period', 'profile'])
                     ->where('status', 'Nonaktif')
                     ->whereHas('profile', function($q) {
                         $q->whereNotNull('graduation_year'); // Hanya yang sudah lulus
                     });

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%')
                  ->orWhereHas('profile', function($profileQuery) use ($request) {
                      $profileQuery->where('workplace', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $alumnis = $query->paginate(12)->appends($request->all());

        return view('superadmin.membership.alumni_index', compact('alumnis'));
    }
}