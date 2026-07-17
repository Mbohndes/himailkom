<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog; // Cukup dipanggil satu kali saja

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Pencarian deskripsi atau nama user
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter Modul
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter Aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(20)->appends($request->all());

        // Ambil daftar modul yang ada secara dinamis untuk dropdown filter
        $modules = ActivityLog::select('module')->distinct()->pluck('module');

        // CATATAN: Pastikan nama folder Anda di resources/views/superadmin/
        // benar-benar menggunakan underscore (activity_logs) bukan strip (-).
        return view('superadmin.activity_logs.index', compact('logs', 'modules'));
    }
}