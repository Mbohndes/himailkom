<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Menampilkan statistik ringkas ekosistem CMS Berita.
     */
    public function dashboard()
    {
        $stats = [
            'total' => News::count(),
            'published' => News::where('status', 'Published')->count(),
            'draft' => News::where('status', 'Draft')->count(),
            'scheduled' => News::where('status', 'Scheduled')->count(),
            'total_views' => News::sum('views_count')
        ];

        // 5 Berita Terpopuler berdasarkan jumlah view
        $popularNews = News::with(['category', 'author'])
                           ->orderBy('views_count', 'desc')
                           ->take(5)
                           ->get();

        // MENGAMBIL DATA UNTUK GRAFIK (Tren Publikasi Tahun Ini)
        $chartData = News::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                         ->whereYear('created_at', date('Y'))
                         ->groupBy('month')
                         ->orderBy('month')
                         ->pluck('count', 'month')
                         ->toArray();

        // Format data agar pas 12 bulan (Januari - Desember)
        $monthlyChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyChartData[] = $chartData[$i] ?? 0;
        }

        return view('superadmin.news.dashboard', compact('stats', 'popularNews', 'monthlyChartData'));
    }

    /**
     * Menampilkan daftar semua artikel berita dengan pagination.
     */
    public function index()
    {
        $newsList = News::with(['category', 'author', 'tags'])->latest()->paginate(10);
        return view('superadmin.news.index', compact('newsList'));
    }

    /**
     * Menampilkan form untuk menulis berita baru.
     */
    public function create()
    {
        $categories = \App\Models\NewsCategory::orderBy('name', 'asc')->get();
        $tags = \App\Models\NewsTag::orderBy('name', 'asc')->get();
        
        return view('superadmin.news.create', compact('categories', 'tags'));
    }

    /**
     * Menyimpan data artikel berita baru ke database (Menyembuhkan Error 500 Anda).
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Inputan Form
        $request->validate([
            'title' => 'required|string|max:255',
            'news_category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'status' => 'required|in:Draft,Published,Scheduled',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Batas Maksimal 2MB
            'tags' => 'nullable|array',
            'tags.*' => 'exists:news_tags,id'
        ]);

        // 2. Upload Gambar Sampul / Thumbnail (Jika Pengguna Mengunggah File)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('news_thumbnails', 'public');
        }

        // 3. Atur Tanggal Publikasi Berdasarkan Status Pilihan
        $publishedAt = null;
        if ($request->status === 'Published') {
            $publishedAt = now();
        } elseif ($request->status === 'Scheduled' && $request->filled('published_at')) {
            $publishedAt = $request->published_at;
        }

        // 4. Simpan Record Utama ke Database (Tabel News)
        $news = News::create([
            'author_id' => Auth::id(), // ID Pengurus HIMA yang sedang login
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(), // Tambah stamp waktu agar selalu unik
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
            'allow_comments' => $request->has('allow_comments'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        // 5. Simpan Data Relasi Hubungan Banyak Label (Tabel Pivot Multi-Tags)
        if ($request->has('tags')) {
            $news->tags()->sync($request->tags);
        }

        return redirect()->route('superadmin.news.index')->with('success', 'Berita berhasil disimpan!');
    }

    // Menampilkan Halaman Baca Berita (Frontend)
    public function show($slug)
    {
        // Cari berita berdasarkan slug
        $news = News::with(['author', 'category', 'tags'])->where('slug', $slug)->firstOrFail();
        
        // Tambah jumlah view setiap kali halaman dibuka
        $news->increment('views_count');

        // Ambil 5 berita terbaru LAINNYA untuk Sidebar (kecuali berita yang sedang dibaca)
        $recentNews = News::with('category')
                          ->where('id', '!=', $news->id)
                          ->where('status', 'Published')
                          ->latest()
                          ->take(5)
                          ->get();

        return view('superadmin.news.show', compact('news', 'recentNews'));
    }

    // --- TAMBAHKAN DI BAWAH FUNGSI SHOW ---

    // Menampilkan Form Edit
    public function edit(News $news)
    {
        $categories = \App\Models\NewsCategory::orderBy('name', 'asc')->get();
        $tags = \App\Models\NewsTag::orderBy('name', 'asc')->get();
        
        // Ambil array ID tag yang terhubung dengan berita ini agar mudah di-select di tampilan
        $newsTagIds = $news->tags->pluck('id')->toArray();

        return view('superadmin.news.edit', compact('news', 'categories', 'tags', 'newsTagIds'));
    }

    // Memproses Perubahan Data
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'news_category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'status' => 'required|in:Draft,Published,Scheduled',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:news_tags,id'
        ]);

        // Proses Thumbnail Baru (Jika diupload)
        $thumbnailPath = $news->thumbnail; 
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama dari server jika ada
            if ($news->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($news->thumbnail)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($news->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('news_thumbnails', 'public');
        }

        // Atur Ulang Tanggal Publikasi
        $publishedAt = $news->published_at;
        if ($request->status === 'Published' && !$news->published_at) {
            $publishedAt = now(); // Jika baru dipublish sekarang
        } elseif ($request->status === 'Scheduled' && $request->filled('published_at')) {
            $publishedAt = $request->published_at;
        } elseif ($request->status === 'Draft') {
            $publishedAt = null;
        }

        // Update ke Database (Slug tidak kita ubah agar link lama yang sudah dibagikan tidak error 404)
        $news->update([
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
            'allow_comments' => $request->has('allow_comments'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        // Update Relasi Tag
        if ($request->has('tags')) {
            $news->tags()->sync($request->tags);
        } else {
            $news->tags()->detach(); // Kosongkan jika tidak ada tag yang dipilih
        }

        return redirect()->route('superadmin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Menghapus Berita secara Permanen
    public function destroy(News $news)
    {
        // Hapus file gambar dari server
        if ($news->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($news->thumbnail)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($news->thumbnail);
        }
        
        // Putus relasi dengan tag
        $news->tags()->detach();
        
        // Hapus data berita
        $news->delete();
        
        return redirect()->route('superadmin.news.index')->with('success', 'Berita berhasil dihapus secara permanen!');
    }
}
