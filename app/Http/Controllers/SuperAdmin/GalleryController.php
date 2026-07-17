<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        // Menampilkan album berbentuk Grid (kartu), diurutkan dari kegiatan terbaru
        $albums = Album::orderBy('activity_date', 'desc')->paginate(12);
        return view('superadmin.gallery.index', compact('albums'));
    }

    public function create()
    {
        // Tolak Anggota yang mencoba menambah galeri via URL
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Hanya pengurus yang dapat mengunggah dokumentasi.');
        }
        
        // ... kode asli Anda di bawahnya ...
    }

    

    public function store(Request $request)
    {
        // [KEAMANAN] Tolak Anggota yang mencoba menembak proses simpan galeri via POST URL
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Hanya pengurus yang dapat mengunggah dokumentasi.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'drive_link' => 'required|url',
            'activity_date' => 'nullable|date',
            'division' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Opsional, maks 2MB
            'description' => 'nullable|string'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('gallery_thumbnails', 'public');
        }

        Album::create([
            'title' => $request->title,
            'drive_link' => $request->drive_link,
            'activity_date' => $request->activity_date,
            'division' => $request->division,
            'thumbnail' => $thumbnailPath,
            'description' => $request->description,
        ]);

        return redirect()->route('superadmin.gallery.index')->with('success', 'Album baru berhasil ditambahkan!');
    }

    public function destroy($album)
    {
        // Tolak Anggota yang mencoba menghapus galeri via URL
        if (auth()->user()->hasRole('Anggota')) {
            abort(403, 'Akses Ditolak: Anda tidak dapat menghapus dokumentasi ini.');
        }
        
        // ... kode asli Anda di bawahnya ...
    }
}