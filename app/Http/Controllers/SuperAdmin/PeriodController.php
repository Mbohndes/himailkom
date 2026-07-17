<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::orderBy('start_year', 'desc')->paginate(10);
        return view('superadmin.masterdata.periods_index', compact('periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|digits:4',
            'end_year' => 'required|digits:4',
            'status' => 'required|in:Aktif,Arsip,Persiapan',
        ]);

        Period::create($request->all());
        return redirect()->back()->with('success', 'Periode baru berhasil ditambahkan!');
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|digits:4',
            'end_year' => 'required|digits:4',
        ]);

        $period->update($request->all());
        return redirect()->back()->with('success', 'Data periode berhasil diperbarui!');
    }

    public function show(Period $period)
    {
        // Hitung statistik (opsional, berapa anggota di periode ini)
        $memberCount = \App\Models\User::where('period_id', $period->id)->count();
        return view('superadmin.masterdata.periods_show', compact('period', 'memberCount'));
    }

    // FUNGSI KHUSUS: Mengaktifkan Periode
    public function activate(Period $period)
    {
        DB::beginTransaction();
        try {
            // Ubah seluruh periode lain yang sedang Aktif menjadi Arsip (Hanya boleh 1 yang aktif)
            Period::where('status', 'Aktif')->update(['status' => 'Arsip']);
            
            // Aktifkan periode yang dipilih
            $period->update(['status' => 'Aktif']);
            
            DB::commit();
            return redirect()->back()->with('success', $period->name . ' resmi diaktifkan. Periode lama telah diarsipkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengaktifkan periode.');
        }
    }

    // FUNGSI KHUSUS: Mengarsipkan Periode
    public function archive(Period $period)
    {
        $period->update(['status' => 'Arsip']);
        return redirect()->back()->with('success', $period->name . ' telah dipindahkan ke Arsip.');
    }

    public function destroy(Period $period)
    {
        $period->delete();
        return redirect()->back()->with('success', 'Periode berhasil dihapus dari sistem.');
    }
}