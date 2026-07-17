<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Proker;
use App\Models\ProkerCommittee;
use App\Models\ProkerCommitteeMember;
use App\Models\User;
use Illuminate\Http\Request;

class ProkerCommitteeController extends Controller
{
    public function index(Proker $proker)
    {
        // Ambil struktur kepanitiaan beserta anggotanya
        $committees = ProkerCommittee::with('members.user')->where('proker_id', $proker->id)->get();
        
        // Ambil semua user (anggota HIMA) untuk pilihan dropdown
        $users = User::orderBy('name', 'asc')->get();

        return view('superadmin.prokers.committee', compact('proker', 'committees', 'users'));
    }

    // 1. Membuat divisi baru dalam kepanitiaan (misal: Divisi Acara, Kuota: 4)
    public function storeRole(Request $request, Proker $proker)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
        ]);

        ProkerCommittee::create([
            'proker_id' => $proker->id,
            'role_name' => $request->role_name,
            'quota' => $request->quota,
        ]);

        return redirect()->back()->with('success', 'Divisi kepanitiaan berhasil ditambahkan!');
    }

    // 2. BPH Menunjuk Anggota Secara Langsung (Otomatis Disetujui)
    public function assignMember(Request $request, Proker $proker)
    {
        $request->validate([
            'proker_committee_id' => 'required|exists:proker_committees,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Cek apakah user sudah terdaftar di divisi ini
        $exists = ProkerCommitteeMember::where('proker_committee_id', $request->proker_committee_id)
                                       ->where('user_id', $request->user_id)
                                       ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Anggota tersebut sudah ada di divisi ini.');
        }

        ProkerCommitteeMember::create([
            'proker_committee_id' => $request->proker_committee_id,
            'user_id' => $request->user_id,
            'status' => 'Disetujui' // Karena yang melakukan adalah Super Admin / BPH
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditugaskan ke dalam panitia!');
    }

    // 3. BPH Meng-ACC Usulan Nama dari Kepala Divisi
    public function approveMember(ProkerCommitteeMember $member)
    {
        $member->update(['status' => 'Disetujui']);

        return redirect()->back()->with('success', 'Usulan anggota berhasil disetujui!');
    }

    // 4. Menghapus Anggota dari Panitia
    public function removeMember(ProkerCommitteeMember $member)
    {
        $member->delete();
        return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan dari kepanitiaan.');
    }
}