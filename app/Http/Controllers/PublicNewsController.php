<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class PublicNewsController extends Controller
{
    // 1. Fungsi untuk halaman "Lihat Semua Berita"
    public function index()
    {
        // Ambil berita, urutkan dari yang paling baru, dan buat pagination (9 berita per halaman)
        $berita = News::orderBy('created_at', 'desc')->paginate(9);
        
        return view('berita.index', compact('berita'));
    }

    // 2. Fungsi untuk halaman "Baca Selengkapnya"
    public function show($id)
    {
        // Cari berita yang diklik
        $news = News::where('id', $id)->orWhere('slug', $id)->firstOrFail();
        
        // Ambil 4 berita lainnya (kecualikan yang sedang dibaca)
        $beritaLainnya = News::where('id', '!=', $news->id)
                             ->orderBy('created_at', 'desc')
                             ->take(4)
                             ->get();

        return view('berita.show', compact('news', 'beritaLainnya'));
    }
}