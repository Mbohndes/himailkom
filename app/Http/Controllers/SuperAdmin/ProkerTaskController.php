<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Proker;
use App\Models\ProkerStage;
use App\Models\ProkerTask;
use App\Models\ProkerTaskAssignee;
use App\Models\ProkerCommitteeMember;
use Illuminate\Http\Request;

class ProkerTaskController extends Controller
{
    // Menampilkan Papan Kanban
    public function board(Proker $proker)
    {
        // Ambil tahapan beserta tugas dan orang yang ditugaskan
        $stages = ProkerStage::with(['tasks.assignees.user'])
                             ->where('proker_id', $proker->id)
                             ->orderBy('order_index', 'asc')
                             ->get();

        // Ambil HANYA panitia yang sudah di-ACC untuk opsi penugasan
        $panitia = ProkerCommitteeMember::with('user')
                                        ->whereHas('committee', function($query) use ($proker) {
                                            $query->where('proker_id', $proker->id);
                                        })
                                        ->where('status', 'Disetujui')
                                        ->get();

        return view('superadmin.prokers.board', compact('proker', 'stages', 'panitia'));
    }

    // Menyimpan Kolom Tahapan Baru
    public function storeStage(Request $request, Proker $proker)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $lastOrder = ProkerStage::where('proker_id', $proker->id)->max('order_index') ?? 0;

        ProkerStage::create([
            'proker_id' => $proker->id,
            'name' => $request->name,
            'order_index' => $lastOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Tahapan berhasil ditambahkan!');
    }

    // Menyimpan Kartu Tugas Baru
    // Menyimpan Kartu Tugas Baru
    public function storeTask(Request $request, Proker $proker)
    {
        $request->validate([
            'stage_id' => 'required|exists:proker_stages,id', // Validasi ID Tahapan
            'name' => 'required|string|max:255',
            'priority' => 'required|in:Rendah,Sedang,Tinggi,Mendesak',
            'assignees' => 'required|array'
        ]);

        $task = ProkerTask::create([
            'proker_stage_id' => $request->stage_id, // Diambil dari input tersembunyi
            'name' => $request->name,
            'priority' => $request->priority,
        ]);

        // Masukkan data anggota yang ditugaskan
        foreach ($request->assignees as $userId) {
            ProkerTaskAssignee::create([
                'proker_task_id' => $task->id,
                'user_id' => $userId
            ]);
        }

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan ke dalam papan!');
    }
    // Fungsi Menghapus Tahapan (Kolom)
    public function destroyStage(ProkerStage $stage)
    {
        $stage->delete();
        return redirect()->back()->with('success', 'Tahapan berhasil dihapus dari papan.');
    }

    // Fungsi Menghapus Tugas (Kartu)
    public function destroyTask(ProkerTask $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }
}