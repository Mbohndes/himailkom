<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsTagController extends Controller
{
    public function index()
    {
        $tags = NewsTag::withCount('news')->orderBy('name', 'asc')->paginate(15);
        return view('superadmin.news.tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:news_tags,name']);

        NewsTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Tag berhasil ditambahkan!');
    }

    public function update(Request $request, NewsTag $tag)
    {
        $request->validate(['name' => 'required|string|max:255|unique:news_tags,name,' . $tag->id]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Tag berhasil diperbarui!');
    }

    public function destroy(NewsTag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('success', 'Tag berhasil dihapus!');
    }
}