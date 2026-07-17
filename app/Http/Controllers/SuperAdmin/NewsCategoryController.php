<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::withCount('news')->orderBy('name', 'asc')->paginate(10);
        return view('superadmin.news.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name',
            'description' => 'nullable|string'
        ]);

        NewsCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Kategori berita berhasil ditambahkan!');
    }

    public function update(Request $request, NewsCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Kategori berita berhasil diperbarui!');
    }

    public function destroy(NewsCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}