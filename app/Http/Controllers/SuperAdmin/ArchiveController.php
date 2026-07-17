<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = Archive::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $archives = $query->paginate(10)->appends($request->all());

        $categories = [
            'Proposal', 'LPJ', 'Surat Masuk', 'Surat Keluar', 
            'SK', 'AD/ART', 'SOP', 'Notulen', 'Template', 'Dokumen Lainnya'
        ];

        return view('superadmin.archives.index', compact('archives', 'categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'drive_link' => 'nullable|url', // Harus format URL valid
            'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:10240', // Opsional, max 10MB
            'description' => 'nullable|string'
        ]);

        // Cek validasi logis: minimal satu metode harus diisi
        if (!$request->filled('drive_link') && !$request->hasFile('file')) {
            return redirect()->back()->withErrors(['error' => 'Anda harus memasukkan Link Google Drive atau mengunggah file fisik.']);
        }

        // Proses simpan file lokal jika ada yang diunggah
        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('archives', 'public');
        }

        Archive::create([
            'title' => $request->title,
            'category' => $request->category,
            'drive_link' => $request->drive_link,
            'file_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diarsipkan!');
    }

    public function destroy(Archive $archive)
    {
        // Hapus file fisik dari storage jika ada
        if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
            Storage::disk('public')->delete($archive->file_path);
        }
        
        $archive->delete();

        return redirect()->back()->with('success', 'Arsip berhasil dihapus!');
    }
}