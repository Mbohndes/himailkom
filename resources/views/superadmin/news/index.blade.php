@extends('layouts.superadmin')
@section('title', 'Semua Berita')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Semua Berita</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelola seluruh artikel, pengumuman, dan publikasi.</p>
        </div>
        <a href="{{ route('superadmin.news.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tulis Berita Baru
        </a>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-4">
        <input type="text" placeholder="Cari judul berita..." class="flex-1 bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#5442F5]">
        <select class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
            <option value="">Semua Kategori</option>
            <!-- Opsional: Loop kategori di sini -->
        </select>
        <select class="bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 w-full sm:w-48">
            <option value="">Semua Status</option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
            <option value="Scheduled">Scheduled</option>
        </select>
        <button class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm">Filter</button>
    </div>

    <!-- Tabel Data Berita -->
    <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F4F7FE] text-slate-500 text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4 w-12"><input type="checkbox" class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]"></th>
                        <th class="px-6 py-4">Informasi Berita</th>
                        <th class="px-6 py-4">Penulis & Kategori</th>
                        <th class="px-6 py-4">Statistik</th>
                        <th class="px-6 py-4">Status & Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse ($newsList as $news)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4"><input type="checkbox" class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]"></td>
                        
                        <!-- Kolom Judul & Thumbnail -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-12 rounded-lg bg-slate-200 flex-shrink-0 bg-cover bg-center" style="background-image: url('{{ $news->thumbnail ? asset('storage/'.$news->thumbnail) : 'https://placehold.co/150x100?text=News' }}')"></div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm mb-1 line-clamp-1">{{ $news->title }}</div>
                                    <div class="flex items-center gap-2">
                                        @if($news->is_featured)
                                            <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-0.5 rounded">Featured</span>
                                        @endif
                                        @if($news->is_breaking)
                                            <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded">Breaking</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Kolom Penulis & Kategori -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $news->author->name ?? '-' }}</div>
                            <div class="text-xs text-slate-400 mt-0.5 font-medium">{{ $news->category->name ?? 'Uncategorized' }}</div>
                        </td>

                        <!-- Kolom Statistik -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-slate-500 font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($news->views_count ?? 0, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Kolom Status -->
                        <td class="px-6 py-4">
                            @if($news->status === 'Published')
                                <span class="bg-[#2CE574]/20 text-[#14C95A] text-xs font-bold px-2.5 py-1 rounded-md">Published</span>
                            @elseif($news->status === 'Draft')
                                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-md">Draft</span>
                            @elseif($news->status === 'Scheduled')
                                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-md">Scheduled</span>
                            @else
                                <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2.5 py-1 rounded-md">Archived</span>
                            @endif
                            <div class="text-[11px] text-slate-400 mt-1 font-medium">
                                {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('d M Y, H:i') : 'Belum rilis' }}
                            </div>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 flex justify-end gap-2">
                            <a href="{{ route('superadmin.news.show', $news->slug) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Artikel">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </a>
                            
                            <a href="{{ route('superadmin.news.edit', $news->id) }}" class="p-2 text-[#5442F5] hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Berita">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <form action="{{ route('superadmin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors" title="Hapus Berita">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                            Belum ada artikel berita yang ditulis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginasi -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $newsList->links() }}
        </div>
    </div>
</div>
@endsection
